<?php

namespace App\Enum;

/**
 * Enum untuk status talent pull kandidat
 */
enum StatusCandidateRecruitment: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
