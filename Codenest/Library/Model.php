<?php
namespace Codenest\Library ;

use Codenest\Library\App as App ;
/**
 *
 */
class Model
{
    protected $db;
    protected $dbTable;

    public function __construct()
    {
        $this->db = App::db();
    }
}
