<?php
namespace App\Enums;
enum RoomStatus: string {
    case Vacant = 'vacant';           // سماوي فاتح
    case Reserved = 'reserved';       // برتقالي
    case OutOfService = 'out_of_service'; // أخضر (معطلة)
    case PartiallyReserved = 'partial';   // زهر
    case AlwaysReserved = 'always';       // أحمر
}
