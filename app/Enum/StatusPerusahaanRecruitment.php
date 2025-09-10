<?php

namespace App\Enum;

/**
 * Enum untuk status talent pull perusahaan
 */
enum StatusPerusahaanRecruitment: string
{
    case WAITING = 'waiting';
    case INTERVIEWED = 'interviewed';
    case REJECTED = 'rejected';
    case APPROVED = 'approved';
}
