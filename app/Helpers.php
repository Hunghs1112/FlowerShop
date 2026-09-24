<?php

// Helper functions for FlowerShop application

/**
 * Lấy nội dung với giá trị mặc định.
 * Hiện tại chỉ trả về giá trị mặc định.
 *
 * @param string $key Key của content
 * @param mixed $default Giá trị mặc định nếu không tìm thấy
 * @return mixed Nội dung hoặc giá trị mặc định
 */
function content(string $key, $default = '')
{
    return $default;
}
