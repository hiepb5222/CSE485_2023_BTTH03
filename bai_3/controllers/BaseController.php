<?php




abstract class BaseController
{

    const VIEW_FOLDER = 'views';

    const SERVICES_FOLDER ='services';

    /*

     Description : path name :" folder.file.name

     lấy từ sau thư mục view

    */

    protected function view($viewPath , array $data = [])
    {

        foreach ($data as $key => $value)

        {

            $$key  = $value;

        }

        include self::VIEW_FOLDER .'/' . str_replace('.', '/', $viewPath) . '.php';

    }

    protected function loadServices($servicesPath)
    {

        include self::SERVICES_FOLDER .'/' . $servicesPath . '.php';

    }

}
