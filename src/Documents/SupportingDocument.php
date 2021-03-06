<?php namespace Echosign\Documents;

use Echosign\Responses\AgreementDocuments;

class SupportingDocument {

    protected $displayLabel, $supportingDocumentId, $fieldName, $mimeType;
    protected $agreementDoc;

    /**
     * @param array $config
     * @param AgreementDocuments $agreementDocuments
     */
    public function __construct( array $config, AgreementDocuments $agreementDocuments )
    {
        foreach(['displayLabel', 'supportingDocumentId', 'fieldName', 'mimeType'] as $c) {
            $this->$c = \Echosign\array_get( $config, $c );
        }

        $this->agreementDoc = $agreementDocuments;
    }

    /**
     * @return string
     */
    public function getDisplayLabel()
    {
        return $this->displayLabel;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->supportingDocumentId;
    }

    /**
     * @param string $savePath
     * @param $fileName
     * @return string|boolean if successful the saved path to the file or false if it fails
     */
    public function downloadDocument($savePath, $fileName)
    {
        $agreement = $this->agreementDoc->getAgreement();

        $file = $agreement->document( $this->agreementDoc->getAgreementId(), $this->getId(), $fileName );

        if( false === $file ) {
            return false;
        }

        $newName = $savePath . DIRECTORY_SEPARATOR . $this->name;

        if( rename( $file, $newName) ) {
            return $newName;
        }

        return false;
    }
}