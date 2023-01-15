<?php

namespace Iqbal\StockManager\Model;

class UserProfileUpdateRequest
{
     public string $old_password;
     public string $new_password;
     public string $repeat_new_password;
}
