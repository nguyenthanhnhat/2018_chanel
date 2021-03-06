<?php
namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\Chanel;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;

/**
 * Class CategoryAPIController
 * @package App\Http\Controllers\API
 *
 * @author quyhbn <quyhbn@nal.vn>
 */
class CategoryAPIController extends AppBaseController
{
    private $categoryRepository;
    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    /**
     * CategoryAPIController constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param BannerRepository $bannerRepository
     */
    public function __construct(CategoryRepository $categoryRepository, BannerRepository $bannerRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Get All information about Category and Chanel
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
//        $result = [
//            [
//                'url_banner' => $this->getLatestUrlBanner(),
//            ]
//        ];

        $result = [
            [
                'url_banner' => $this->getLatestUrlBanner(),
                'categories' => $this->getCategories()
            ]
        ];

//        $list_data = $this->categoryRepository->all();
//
//        foreach ($list_data as $item) {
//            $result = array_merge($result,
//                [
//                    [
//                        'categories' => [
//                            'name' => $item['title'],
//                            'videos' => $this->getChanelByCategoryId($item)
//                        ]
//                    ]
//                ]);
//        }

        return $this->sendResponse($result, 'Success');
    }

    public function getCategories()
    {
        $result = [];
        $list_data = $this->categoryRepository->all();

        foreach ($list_data as $item) {
            $result = array_merge($result,[
                [
                    'name' => $item['title'],
                    'videos' => $this->getChanelByCategoryId($item)
                ]
            ]);
        }
        return $result;
    }

    /**
     * Get Chanel by category_id
     *
     * @param Chanel $item
     * @return array
     */
    public function getChanelByCategoryId($item)
    {
        $result_chanel = [];

        if (!empty($item->chanels)) {
            foreach ($item->chanels as $chanel) {
                $result_chanel = array_merge($result_chanel,[
                    [
                        'name' => $chanel->name,
                        'description' => isset($chanel->description) ? $chanel->description : '',
                        'url' => $chanel->video_url,
                        'image' => request()->root() . '/images/' . $chanel->image
                    ]
                ]);
            }
        }
        else {
            $result_chanel = [];
        }

        return $result_chanel;
    }

    /**
     * @return string
     */
    public function getLatestUrlBanner()
    {
        $result = '';
        $banner = $this->bannerRepository->orderBy('updated_at', 'DESC')->first();

        if (!empty($banner)) {
            $result = request()->root() . '/images/' . $banner->url_banner;
        }

        return $result;
    }
}