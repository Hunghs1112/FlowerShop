<?php

// Helper functions for FlowerShop application

/**
 * Lấy nội dung content block theo key.
 *
 * @param string $key Key của content block
 * @param mixed $default Giá trị mặc định nếu không tìm thấy
 * @return mixed Nội dung của block hoặc giá trị mặc định
 */
function content(string $key, $default = '')
{
    return \App\Models\ContentBlock::get($key, $default);
}
