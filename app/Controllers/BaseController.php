<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use stdClass;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * @var BaseConnection
     */
    protected $db;

    protected $settings;

    /**
     * @var array
     */
    protected $models;

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['all'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->db = db_connect();

        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    /**
     * 
     * @return \App\Models\UserModel
     */
    public function getUserModel()
    {
        if (!isset($this->models['user'])) {
            $this->models['user'] = new \App\Models\UserModel($this->db);
        }

        return $this->models['user'];
    }

    /**
     * 
     * @return \App\Models\UserGroupModel
     */
    public function getUserGroupModel()
    {
        if (!isset($this->models['user-group'])) {
            $this->models['user-group'] = new \App\Models\UserGroupModel($this->db);
        }

        return $this->models['user-group'];
    }

    /**
     * 
     * @return \App\Models\CustomerModel
     */
    public function getCustomerModel()
    {
        if (!isset($this->models['customer'])) {
            $this->models['customer'] = new \App\Models\CustomerModel($this->db);
        }

        return $this->models['customer'];
    }

    /**
     * 
     * @return \App\Models\ProductModel
     */
    public function getProductModel()
    {
        if (!isset($this->models['product'])) {
            $this->models['product'] = new \App\Models\ProductModel($this->db);
        }

        return $this->models['product'];
    }

    /**
     * 
     * @return \App\Models\BillModel
     */
    public function getBillModel()
    {
        if (!isset($this->models['bill'])) {
            $this->models['bill'] = new \App\Models\BillModel($this->db);
        }

        return $this->models['bill'];
    }

    /**
     * 
     * @return \App\Models\SettingModel
     */
    public function getSettingModel()
    {
        if (!isset($this->models['setting'])) {
            $this->models['setting'] = new \App\Models\SettingModel($this->db);
        }

        return $this->models['setting'];
    }

    public function getSettings()
    {
        if (null == $this->settings) {
            $this->settings = new stdClass;
            $this->settings->storeName = $this->getSettingModel()->get('app.store_name');
            $this->settings->storeAddress = $this->getSettingModel()->get('app.store_address');
        }
        
        return $this->settings;
    }
}
