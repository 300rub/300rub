<?php

/**
 * Class Tocsui_FileUploadController
 */
class Tocsui_FileUploadController extends Phi_Rest_Controller
{

    /**
     * Uploads the file
     *
     * method POST
     *
     * @return Phi_Data_Structure
     */
    public function appendAction()
    {
        $logic = new Tocsui_Logic_FileUpload(new Zend_File_Transfer_Adapter_Http());

        $logic->uploadFile();

        $data = array(
            "name" => $logic->getName(),
            "link" => $logic->getHttpLink()
        );

        return new Phi_Data_Structure($data, 'system');
    }
}
