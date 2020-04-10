<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSongAPIRequest;
use App\Http\Requests\API\UpdateSongAPIRequest;
use App\Models\Song;
use App\Repositories\SongRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
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
     *      path="/songs",
     *      summary="Get a listing of the Songs.",
     *      tags={"Song"},
     *      description="Get all Songs",
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
        $songs = $this->songRepository->all();

        return $this->sendResponse($songs->toArray(), 'Songs retrieved successfully');
    }

    /**
     * @param CreateSongAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/songs",
     *      summary="Store a newly created Song in storage",
     *      tags={"Song"},
     *      description="Store Song",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Song that should be stored",
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
    public function store(CreateSongAPIRequest $request)
    {
        $input = $request->all();

        $songs = $this->songRepository->create($input);

        return $this->sendResponse($songs->toArray(), 'Song saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/songs/{id}",
     *      summary="Display the specified Song",
     *      tags={"Song"},
     *      description="Get Song",
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
     *      path="/songs/{id}",
     *      summary="Update the specified Song in storage",
     *      tags={"Song"},
     *      description="Update Song",
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
     *      path="/songs/{id}",
     *      summary="Remove the specified Song from storage",
     *      tags={"Song"},
     *      description="Delete Song",
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
