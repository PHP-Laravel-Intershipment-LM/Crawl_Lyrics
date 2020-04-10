<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlaylistAPIRequest;
use App\Http\Requests\API\UpdatePlaylistAPIRequest;
use App\Models\Playlist;
use App\Repositories\PlaylistRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PlaylistController
 * @package App\Http\Controllers\API
 */

class PlaylistAPIController extends InfyOmBaseController
{
    /** @var  PlaylistRepository */
    private $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepo)
    {
        $this->playlistRepository = $playlistRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/playlists",
     *      summary="Get a listing of the Playlists.",
     *      tags={"Playlist"},
     *      description="Get all Playlists",
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
     *                  @SWG\Items(ref="#/definitions/Playlist")
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
        $this->playlistRepository->pushCriteria(new RequestCriteria($request));
        $this->playlistRepository->pushCriteria(new LimitOffsetCriteria($request));
        $playlists = $this->playlistRepository->all();

        return $this->sendResponse($playlists->toArray(), 'Playlists retrieved successfully');
    }

    /**
     * @param CreatePlaylistAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/playlists",
     *      summary="Store a newly created Playlist in storage",
     *      tags={"Playlist"},
     *      description="Store Playlist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Playlist that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Playlist")
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
     *                  ref="#/definitions/Playlist"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePlaylistAPIRequest $request)
    {
        $input = $request->all();

        $playlists = $this->playlistRepository->create($input);

        return $this->sendResponse($playlists->toArray(), 'Playlist saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/playlists/{id}",
     *      summary="Display the specified Playlist",
     *      tags={"Playlist"},
     *      description="Get Playlist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Playlist",
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
     *                  ref="#/definitions/Playlist"
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
        /** @var Playlist $playlist */
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            return Response::json(ResponseUtil::makeError('Playlist not found'), 404);
        }

        return $this->sendResponse($playlist->toArray(), 'Playlist retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePlaylistAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/playlists/{id}",
     *      summary="Update the specified Playlist in storage",
     *      tags={"Playlist"},
     *      description="Update Playlist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Playlist",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Playlist that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Playlist")
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
     *                  ref="#/definitions/Playlist"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePlaylistAPIRequest $request)
    {
        $input = $request->all();

        /** @var Playlist $playlist */
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            return Response::json(ResponseUtil::makeError('Playlist not found'), 404);
        }

        $playlist = $this->playlistRepository->update($input, $id);

        return $this->sendResponse($playlist->toArray(), 'Playlist updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/playlists/{id}",
     *      summary="Remove the specified Playlist from storage",
     *      tags={"Playlist"},
     *      description="Delete Playlist",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Playlist",
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
        /** @var Playlist $playlist */
        $playlist = $this->playlistRepository->find($id);

        if (empty($playlist)) {
            return Response::json(ResponseUtil::makeError('Playlist not found'), 404);
        }

        $playlist->delete();

        return $this->sendResponse($id, 'Playlist deleted successfully');
    }
}
