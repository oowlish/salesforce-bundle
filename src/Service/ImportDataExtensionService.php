<?php

declare(strict_types=1);

namespace Oowlish\SalesforceBundle\Service;

use FuelSdk\ET_Client;
use FuelSdk\ET_Import;

class ImportDataExtensionService
{
    private $client;
    private $import;

    public function __construct(ET_Client $client, ET_Import $import)
    {
        $this->client = $client;
        $this->import = $import;
    }

    public function createImport(
        string $importName,
        int $sendableDataExtensionCustomerKey,
        string $csvFileName,
        string $notificationEmail
    ) {
        $this->import->authStub = $this->client;
        $this->import->props = array("Name"=>$importName);
        $this->import->props["CustomerKey"] = $importName;
        $this->import->props["Description"] = "Created with Oowlish Salesforce SDK";
        $this->import->props["AllowErrors"] = "true";
        $this->import->props["DestinationObject"] = array("ObjectID"=>$sendableDataExtensionCustomerKey);
        $this->import->props["FieldMappingType"] = "InferFromColumnHeadings";
        $this->import->props["FileSpec"] = $csvFileName;
        $this->import->props["FileType"] = "CSV";
        $this->import->props["Notification"] = array("ResponseType"=>"email","ResponseAddress"=>$notificationEmail);
        $this->import->props["RetrieveFileTransferLocation"] = array("CustomerKey"=>"ExactTarget Enhanced FTP");
        $this->import->props["UpdateType"] = "Overwrite";

        return $this->import->post();
    }

    public function startImport(string $importName)
    {
        $this->import->authStub = $this->client;
        $this->import->props = array("CustomerKey"=>$importName);

        return $this->import->start();
    }

    public function deleteImport(string $importName)
    {
        $this->import->authStub = $this->client;
        $this->import->props = array("CustomerKey" => $importName);

        return $this->import->delete();
    }
}
