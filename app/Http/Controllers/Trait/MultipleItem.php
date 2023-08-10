<?php

namespace App\Http\Controllers\Trait;

use App\Models\discount;

trait MultipleItem
{

    private function plus($item, $request)
    {
        $plus_price = $item->price + $request->price;
        $minPrice = $item->min_price + $request->price;
        $maxPrice = $item->max_price + $request->price;
        if ($item->price != 0) {
            $item->price = $plus_price;
            $item->save();

        } else {
            $item->min_price = $minPrice;
            $item->max_price = $maxPrice;
            $item->save();

        }
        /** discount value delete */
        $discount_id = discount::where('item_id', $item->id);
        if ($discount_id->count() > 0) {
            if ($request->unsetdiscountitems != null) {
                $check = in_array($item->id, $request->unsetdiscountitems);
                if ($check) {
                    $discount_id->delete();

                } else {
                    if ($item->ykget_discount->base == 'price') {
                        if ($discount_id->first()->discount_price != 0) {
                            $disprice = $plus_price - $discount_id->first()->dec_price;
                            $discount_id->update(['discount_price' => $disprice]);

                        } else {
                            $dismin = $minPrice - $discount_id->first()->dec_price;
                            $dismax = $maxPrice - $discount_id->first()->dec_price;
                            $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                        }
                    } else {
                        if ($discount_id->first()->discount_price != 0) {
                            $disprice = round($plus_price - (($plus_price * $discount_id->first()->percent) / 100));
                            $discount_id->update(['discount_price' => $disprice]);

                        } else {
                            $dismin = round($minPrice - (($minPrice * $discount_id->first()->percent) / 100));
                            $dismax = round($maxPrice - (($maxPrice * $discount_id->first()->percent) / 100));
                            $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                        }
                    }
                }

            } else {
                if ($item->ykget_discount->base == 'price') {
                    if ($discount_id->first()->discount_price != 0) {
                        $disprice = $plus_price - $discount_id->first()->dec_price;
                        $discount_id->update(['discount_price' => $disprice]);

                    } else {
                        $dismin = $minPrice - $discount_id->first()->dec_price;
                        $dismax = $maxPrice - $discount_id->first()->dec_price;
                        $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                    }
                } else {
                    if ($discount_id->first()->discount_price != 0) {
                        $disprice = round($plus_price - (($plus_price * $discount_id->first()->percent) / 100));
                        $discount_id->update(['discount_price' => $disprice]);

                    } else {
                        $dismin = round($minPrice - (($minPrice * $discount_id->first()->percent) / 100));
                        $dismax = round($maxPrice - (($maxPrice * $discount_id->first()->percent) / 100));
                        $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                    }
                }
            }
        }
    }
    private function minus($item, $request)
    {
        if ($item->price == 0) {
            $plus_price = 0;
            $minPrice = $item->min_price - $request->price;
            $maxPrice = $item->max_price - $request->price;
        } else {
            $plus_price = $item->price - $request->price;
            $minPrice = 0;
            $maxPrice = 0;
        }

        if ($plus_price < 0 or $minPrice < 0 or $maxPrice < 0) {
            return 'error';
        } else {
            if ($item->price != 0) {
                $item->price = $plus_price;
                $item->save();

            } else {
                $item->min_price = $minPrice;
                $item->max_price = $maxPrice;
                $item->save();

            }
            /** discount value delete */
            $discount_id = discount::where('item_id', $item->id);
            if ($discount_id->count() > 0) {
                if ($request->unsetdiscountitems != null) {
                    $check = in_array($item->id, $request->unsetdiscountitems);
                    if ($check) {
                        $discount_id->delete();

                    } else {
                        if ($item->ykget_discount->base == 'price') {
                            if ($discount_id->first()->discount_price != 0) {
                                $disprice = $plus_price - $discount_id->first()->dec_price;
                                $discount_id->update(['discount_price' => $disprice]);

                            } else {
                                $dismin = $minPrice - $discount_id->first()->dec_price;
                                $dismax = $maxPrice - $discount_id->first()->dec_price;
                                $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                            }
                        } else {
                            if ($discount_id->first()->discount_price != 0) {
                                $disprice = round($plus_price - (($plus_price * $discount_id->first()->percent) / 100));
                                $discount_id->update(['discount_price' => $disprice]);

                            } else {
                                $dismin = round($minPrice - (($minPrice * $discount_id->first()->percent) / 100));
                                $dismax = round($maxPrice - (($maxPrice * $discount_id->first()->percent) / 100));
                                $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                            }
                        }
                    }

                } else {
                    if ($item->ykget_discount->base == 'price') {
                        if ($discount_id->first()->discount_price != 0) {
                            $disprice = $plus_price - $discount_id->first()->dec_price;
                            $discount_id->update(['discount_price' => $disprice]);

                        } else {
                            $dismin = $minPrice - $discount_id->first()->dec_price;
                            $dismax = $maxPrice - $discount_id->first()->dec_price;
                            $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                        }
                    } else {
                        if ($discount_id->first()->discount_price != 0) {
                            $disprice = round($plus_price - (($plus_price * $discount_id->first()->percent) / 100));
                            $discount_id->update(['discount_price' => $disprice]);

                        } else {
                            $dismin = round($minPrice - (($minPrice * $discount_id->first()->percent) / 100));
                            $dismax = round($maxPrice - (($maxPrice * $discount_id->first()->percent) / 100));
                            $discount_id->update(['discount_min' => $dismin, 'discount_max' => $dismax]);
                        }
                    }
                }
            }
        }

    }

    private function get_multiple_recap($item, $request)
    {
        if ($request->အလျော့တွက် != null) {
            $item->handmade = $request->အလျော့တွက်;
            $item->save();
        }
        if ($request->လက်ခ != null) {
            $item->charge = $request->လက်ခ;
            $item->save();
        }
        if ($request->undamaged_product != null) {
            $item->undamaged_product = $request->undamaged_product;
            $item->save();
        }
        if ($request->damaged_product != null) {
            $item->damaged_product = $request->damaged_product;
            $item->save();

        }
        if ($request->valuable_product != null) {
            $item->valuable_product = $request->valuable_product;
            $item->save();
        }

    }

}
