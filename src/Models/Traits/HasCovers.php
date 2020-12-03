<?php

namespace XuanChen\CrowdFund\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait HasCovers
{

    /**
     * Notes: 封面图片网络地址转换
     * @Author: <C.Jason>
     * @Date  : 2020/9/1 4:53 下午
     * @return string
     */
    protected function getCoverUrlAttribute(): string
    {
        if ($this->cover) {
            return Storage::url($this->cover);
        } else {
            return '';
        }
    }

    /**
     * Notes: 多图网络地址转换
     * @Author: <C.Jason>
     * @Date  : 2020/9/1 4:53 下午
     * @return \Illuminate\Support\Collection
     */
    protected function getPicturesUrlAttribute(): Collection
    {
        return collect($this->pictures)->map(function ($pic) {
            return Storage::url($pic);
        });
    }

    /**
     * Notes: 拼接视频地址
     * @Author: 玄尘
     * @Date  : 2020/12/3 11:31
     * @return string
     */
    public function getVideoUrlAttribute()
    {
        if ($this->video) {
            return Storage::url($this->video);
        } else {
            return '';
        }
    }

    /**
     * Notes: 获取一张图片
     * @Author: 玄尘
     * @Date  : 2020/12/3 11:33
     */
    public function getOneCoverAttribute()
    {
        if ($this->cover_url) {
            return $this->cover_url;
        }
        if ($this->pictures_url) {
            return $this->pictures_url->first();
        }

        return '';
    }

}
