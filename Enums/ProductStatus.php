<?php

namespace enums;

enum ProductStatus: int
{
    case IN_STOCK = 1; // Còn hàng
    case OUT_OF_STOCK = 2; // Hết hàng
    case DISCONTINUED = 3; // Ngưng bán
    case ON_SALE = 4; // Đang giảm giá
    case NEW_ARRIVAL = 5; // Hàng mới
}
