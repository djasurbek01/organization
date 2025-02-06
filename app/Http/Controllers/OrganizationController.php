<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Activity;

/**
 * @OA\Info(
 *     title="Organization API",
 *     version="1.0",
 *     description="API для организаций, зданий и деятельности"
 * )
 * @OA\Tag(
 *     name="Organizations",
 *     description="API организаций"
 * )
 */
class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/organizations/building/{id}",
     *     summary="Список организаций в здании",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID здания",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Успешно"),
     *     @OA\Response(response=404, description="Здание не найдено")
     * )
     */
    public function byBuilding($buildingId)
    {
        $organizations = Organization::where('building_id', $buildingId)->get();
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activity/{id}",
     *     summary="Список организаций по деятельности",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID деятельности",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Успешно"),
     *     @OA\Response(response=404, description="Деятельности не найден")
     * )
     */
    public function byActivity($activityId)
    {
        $activityIds = Activity::where('id', $activityId)
            ->orWhere('parent_id', $activityId)
            ->pluck('id');
        
        $organizations = Organization::whereHas('activities', function ($query) use ($activityIds) {
            $query->whereIn('activities.id', $activityIds);
        })->get();

        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     summary="Информация о организации",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID организации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Успешно"),
     *     @OA\Response(response=404, description="Организация не найдена")
     * )
     */
    public function show($id)
    {
        $organization = Organization::with(['building', 'activities'])->findOrFail($id);
        return response()->json($organization);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search",
     *     summary="Поиск организаций по названию",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         description="Название организации",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Успешно")
     * )
     */
    public function searchByName(Request $request)
    {
        $query = $request->input('q');
        $organizations = Organization::where('name', 'LIKE', "%{$query}%")->get();
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/location",
     *     summary="Список организаций в географические координаты",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="lat",
     *         in="query",
     *         required=true,
     *         description="Широта",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="lng",
     *         in="query",
     *         required=true,
     *         description="Долгота",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         required=false,
     *         description="Географические координаты в километрах (по умолчанию 10 км)",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(response=200, description="Успешно")
     * )
     */
    public function byLocation(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $radius = $request->input('radius', 10);

        $organizations = Organization::whereHas('building', function ($query) use ($lat, $lng, $radius) {
            $query->whereRaw("
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                [$lat, $lng, $lat, $radius]
            );
        })->get();

        return response()->json($organizations);
    }
}
