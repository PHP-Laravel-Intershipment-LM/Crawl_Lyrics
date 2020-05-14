<?php

namespace App\Http\Controllers\API\ZingMp3;

use App\Http\Requests\API\CreateSongAPIRequest;
use App\Http\Requests\API\UpdateSongAPIRequest;
use App\Models\Song;
use App\Repositories\SongRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Helpers\ZingAPI;
use App\Helpers\Crawler\ZingCrawler;
use Response;

/**
 * Class SongController
 * @package App\Http\Controllers\API
 */

class SongAPIController extends InfyOmBaseController
{
    /** @var  SongRepository */
    private $songRepository;

    public function __construct(SongRepository $songRepo)
    {
        $this->songRepository = $songRepo;
    }
    
    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/song/crawl",
     *      summary="Crawl online song",
     *      tags={"Song Online"},
     *      description="Crawl all information of online song",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="url",
     *          description="url of online Song",
     *          type="string",
     *          required=false,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of online Song",
     *          type="string",
     *          required=false,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="status",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     *                  @SWG\Schema(
     *                      type="object",
     *                      @SWG\Property(
     *                          property="message",
     *                          type="string"
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function crawlSong(Request $request, $task)
    {
        // Check if request is valid
        if (!$request->filled('id') && !$request->filled('url')) {
            return response()->json([
                'status'    => 'false',
                'message'   => 'Parameter is unvalid',
                'data'      => []
            ], 500);
        }

        $apiGenerator = new ZingAPI();
        $crawler = new ZingCrawler();
        $info = []; // Result data
        $id = ''; // Id of song
        if ($request->input('url', false)) {
            // Get id of song from url
            $url = $request->input('url');
            $id = $crawler->getIdSong($url);
        } else {
            $id = $request->input('id');
        }
        // Check id if it exits
        if (Cache::has($id)) {
            $info = Cache::get($id, []);
        } else {
            $urlInfo = $apiGenerator->generateURL(ZingAPI::URL_INFO, $id, null);
            $info = json_decode($crawler->getSourceFromURL($urlInfo), 1);
            // Save it to cache
            Cache::add($id, $info);
        }
        return response()->json([
            'status'    => true,
            'message'   => 'Crawl song success!',
            'data'      => [
                'title'     => $info['data']['title'],
                'artist'    => $info['data']['artists'][0]['name'],
                'thumbnail' => $info['data']['thumbnail'],
                'duration'  => $info['data']['duration'],
                'links'     => $task == 'streaming' ? $info['data']['streaming']['default'] : '',
                'lyric'     => $task == 'lyric' && sizeof($info['data']['lyrics']) > 0 ? $info['data']['lyrics'][0]['content'] : ''
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/songs",
     *      summary="Get all song",
     *      tags={"Song Local Storage"},
     *      description="Get a listing of the song",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Song")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->songRepository->pushCriteria(new RequestCriteria($request));
        $this->songRepository->pushCriteria(new LimitOffsetCriteria($request));
        $song = $this->songRepository->all();

        return $this->sendResponse($song->toArray(), 'song retrieved successfully');
    }

    /**
     * @param CreateSongAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/song",
     *      summary="Store Song",
     *      tags={"Song Local Storage"},
     *      description="Store a newly created Song in storage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Song that should be stored",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/Song")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Song"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSongAPIRequest $request)
    {
        $input = $request->all();

        $song = $this->songRepository->create($input);

        return $this->sendResponse($song->toArray(), 'Song saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/song/{id}",
     *      summary="Get Song",
     *      tags={"Song Local Storage"},
     *      description="Display the specified Song",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Song",
     *          type="integer",
     *          required=false,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Song"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Song $song */
        $song = $this->songRepository->find($id);

        if (empty($song)) {
            return Response::json(ResponseUtil::makeError('Song not found'), 404);
        }

        return $this->sendResponse($song->toArray(), 'Song retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSongAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/song/{id}",
     *      summary="Update Song",
     *      tags={"Song Local Storage"},
     *      description="Update the specified Song in storage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Song",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Song that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Song")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Song"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSongAPIRequest $request)
    {
        $input = $request->all();

        /** @var Song $song */
        $song = $this->songRepository->find($id);

        if (empty($song)) {
            return Response::json(ResponseUtil::makeError('Song not found'), 404);
        }

        $song = $this->songRepository->update($input, $id);

        return $this->sendResponse($song->toArray(), 'Song updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/song/{id}",
     *      summary="Delete Song",
     *      tags={"Song Local Storage"},
     *      description="Remove the specified Song from storage",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Song",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Song $song */
        $song = $this->songRepository->find($id);

        if (empty($song)) {
            return Response::json(ResponseUtil::makeError('Song not found'), 404);
        }

        $song->delete();

        return $this->sendResponse($id, 'Song deleted successfully');
    }
}
