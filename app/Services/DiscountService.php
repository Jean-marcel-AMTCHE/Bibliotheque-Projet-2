<?php

namespace App\Services;

use App\Models\Coupon;

class DiscountService
{
    public function applyCoupon($code, $total)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return [
                'success' => false,
                'message' => 'Coupon invalide',
                'total' => $total
            ];
        }

        if ($coupon->is_percentage) {
            $discount = $total * ($coupon->value / 100);
        } else {
            $discount = $coupon->value;
        }

        $newTotal = max(0, $total - $discount);

        return [
            'success' => true,
            'message' => 'Coupon appliqué avec succès',
            'total' => $newTotal,
            'discount' => $discount,
            'coupon' => $coupon
        ];
    }
}

