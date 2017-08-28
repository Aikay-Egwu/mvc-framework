<?php
namespace Codenest\Controllers ;

use Codenest\Library\Controller ;
use Codenest\Models\Home as HomeModel;

class Home extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data) ;
        $this->model = new HomeModel();
    }

    public function index()
    {
       $this->route();
    }
}
