<?php
class CurlOption extends Model
{
    protected $fillable = ['options', 'name'];

    // Мутатор для преобразования массива в JSON перед сохранением в базу данных
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    // Аксессор для преобразования JSON обратно в массив при получении из базы данных
    public function getOptionsAttribute($value)
    {
        return json_decode($value, true);
    }
}
