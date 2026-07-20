<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ConfigurationModel;

class TransactionController extends BaseController
{
    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->configuration = new ConfigurationModel();
    }
}