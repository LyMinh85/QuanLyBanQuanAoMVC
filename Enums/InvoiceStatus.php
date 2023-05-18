<?php

namespace enums;

enum InvoiceStatus: int
{
    case PENDING = 1; // Đang chờ xử lý
    case APPROVED = 2; // Chấp nhận đơn nhập hàng
    case PAID = 3; // Đã trả hết tiền và nhận đầy đủ hàng hóa
}
