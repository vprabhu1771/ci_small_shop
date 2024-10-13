<?php

namespace App\Controllers\Api\V2;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\API\ResponseTrait;

use App\Models\Brand;

class BrandController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $brandModel = new Brand();

        // Fetch all brands
        $brands = $brandModel->findAll();

        // Transform the brands data
        $transformedBrands = array_map(function($brand) use ($brandModel) {
            // Create a new Brand object to use the getLogoImage() method
            $brandInstance = new Brand();
            $brandInstance->image_path = $brand['image_path'];

            return [
                'id' => $brand['id'],
                'name' => $brand['name'],
                'image_path' => $brandInstance->getImage(),  // Call the method using the instance
            ];
        }, $brands);

        // Return response with transformed brands
        return $this->respond([
            'status' => ResponseInterface::HTTP_OK,
            'message' => 'Brands retrieved successfully',
            'data' => $transformedBrands
        ], ResponseInterface::HTTP_OK);
    }


}