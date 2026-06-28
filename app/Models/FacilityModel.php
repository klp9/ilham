<?php

namespace App\Models;

use CodeIgniter\Model;

class FacilityModel extends Model
{
    protected $table            = 'facilities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRoomFacilities($roomId)
    {
        return $this->db->table('room_facilities')
                        ->select('facilities.*')
                        ->join('facilities', 'facilities.id = room_facilities.facility_id')
                        ->where('room_facilities.room_id', $roomId)
                        ->get()
                        ->getResultArray();
    }

    public function syncRoomFacilities($roomId, array $facilityIds)
    {
        $this->db->table('room_facilities')->where('room_id', $roomId)->delete();

        if (!empty($facilityIds)) {
            $insertData = [];
            foreach ($facilityIds as $facilityId) {
                $insertData[] = [
                    'room_id'     => $roomId,
                    'facility_id' => $facilityId,
                ];
            }
            $this->db->table('room_facilities')->insertBatch($insertData);
        }
    }
}
