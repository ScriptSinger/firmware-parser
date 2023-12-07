<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class CurlService
{
    private $ch;
    private $host;
    private $options;


    // Возвращает новый экземпляр класса cURL с указанным хостом.
    public static function app()
    {
        return new self(Config::get('curl.url'));
    }

    // Инициализирует сеанс cURL и устанавливает для параметров по умолчанию, таких как CURLOPT_RETURNTRANSFER, значение true.
    private function __construct($host)
    {
        $this->ch = curl_init();
        $this->host = $host;
        $this->options = array(CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => array());
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        $this->set_config();
    }

    // Закрывает сеанс cURL.
    public function __destruct()
    {
        curl_close($this->ch);
    }

    private function set_config()
    {
        $settings = Config::get('curl.settings');
        if (empty($settings)) {
            // Обработка ошибки, например, выброс исключения или логгирование.
            // Важно уведомить о том, что конфигурационные файлы не найдены или пусты.
            throw new \RuntimeException('Curl configuration files not found or empty.');
        }
        curl_setopt_array($this->ch, $settings);
        foreach ($settings as $key => $val) {
            $this->options[$key] = $val;
        }
    }

    // Устанавливает параметр для сеанса cURL.
    public function set($name, $value)
    {
        $this->options[$name] = $value;
        curl_setopt($this->ch, $name, $value);
        return $this;
    }

    // Получает значение параметра для сеанса cURL.
    public function get($name)
    {
        return $this->options[$name];
    }

    public function getOptions()
    {
        return $this->options;
    }

    // Устанавливает путь для сеанса cURL для сохранения и извлечения файлов cookie.
    public function cookie($path)
    {
        $this->set(CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'] . '/' . $path);
        $this->set(CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'] . '/' . $path);
        return $this;
    }

    // Устанавливает проверку SSL для сеанса cURL.
    public function ssl($option)
    {
        $this->set(CURLOPT_SSL_VERIFYPEER, $option);
        $this->set(CURLOPT_SSL_VERIFYHOST, $option);
        return $this;
    }

    // Включает или отключает отображение заголовков в ответе.
    public function headers($enable = true)
    {
        $this->set(CURLOPT_HEADER, $enable);
        return $this;
    }

    // Устанавливает, будет ли сеанс cURL следовать перенаправлениям или нет.
    public function follow($enable = true)
    {
        $this->set(CURLOPT_FOLLOWLOCATION, $enable);
        return $this;
    }

    // Устанавливает URL-адрес реферера для сеанса cURL.
    public function referer($url)
    {
        $this->set(CURLOPT_REFERER, $url);
        return $this;
    }

    // Устанавливает пользовательский агент для сеанса cURL.
    public function agent($agent)
    {
        $this->set(CURLOPT_USERAGENT, $agent);
        return $this;
    }

    // Устанавливает сеанс cURL для отправки запроса POST или нет, а также устанавливает поля POST, если данные предоставлены.
    public function post(array $data)
    {
        if ($data === false) {
            $this->set(CURLOPT_POST, false);
            return $this;
        }

        $this->set(CURLOPT_POST, true);
        $this->set(CURLOPT_POSTFIELDS, http_build_query($data));
        return $this;
    }

    // Добавляет заголовок к сеансу cURL.
    public function add_header($header)
    {
        $this->options[CURLOPT_HTTPHEADER][] = $header;
        $this->set(CURLOPT_HTTPHEADER, $this->options[CURLOPT_HTTPHEADER]);
        return $this;
    }

    // Добавляет несколько заголовков в сеанс cURL.
    public function add_headers($headers)
    {
        foreach ($headers as $h)
            $this->options[CURLOPT_HTTPHEADER][] = $h;

        $this->set(CURLOPT_HTTPHEADER, $this->options[CURLOPT_HTTPHEADER]);
        return $this;
    }

    // Очищает заголовки для сеанса cURL.
    public function clear_headers()
    {
        $this->options[CURLOPT_HTTPHEADER] = array();
        $this->set(CURLOPT_HTTPHEADER, $this->options[CURLOPT_HTTPHEADER]);
        return $this;
    }

    // Загружает параметры конфигурации для сеанса cURL из файла.
    public function config_load($file)
    {
        $data = file_get_contents($file);
        $data = unserialize($data);
        curl_setopt_array($this->ch, $data);
        foreach ($data as $key => $val) {
            $this->options[$key] = $val;
        }
        return $this;
    }

    // Cохраняет параметры конфигурации для сеанса cURL в файл.
    public function config_save($file)
    {
        $data = serialize($this->options);
        file_put_contents($file, $data);
        return $this;
    }

    // Выполняет запрос cURL с указанным URL-адресом.
    public function request($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->make_url($url));
        $data = curl_exec($this->ch);


        if ($data === false) {
            $error_message = curl_error($this->ch);
            $error_code = curl_errno($this->ch);

            return $this->process_error($error_code, $error_message);
        }
        return $this->process_result($data);
    }


    // Обрабатывает ошибку cURL.
    private function process_error($error_code, $error_message)
    {
        return array(
            'error' => true,
            'error_code' => $error_code,
            'error_message' => $error_message
        );
    }

    // Добавляет хост к URL-адресу, чтобы сформировать полный URL-адрес для запроса cURL.
    private function make_url($url)
    {
        if ($url[0] != '/')
            $url = '/' . $url;

        return $this->host . $url;
    }

    // Обрабатывает результат запроса cURL.
    private function process_result($data)
    {

        if (!isset($this->options[CURLOPT_HEADER]) || !$this->options[CURLOPT_HEADER]) {
            return array(
                'headers' => array(),
                'html' => $data
            );
        }


        $info = curl_getinfo($this->ch);

        $headers_part = trim(substr($data, 0, $info['header_size']));
        $body_part = substr($data, $info['header_size']);


        $headers_part = str_replace("\r\n", "\n", $headers_part);
        $headers = str_replace("\r", "\n", $headers_part);


        $headers = explode("\n\n", $headers);
        $headers_part = end($headers);


        $lines = explode("\n", $headers_part);
        $headers = array();

        $headers['start'] = $lines[0];

        for ($i = 1; $i < count($lines); $i++) {
            $del_pos = strpos($lines[$i], ':');
            $name = substr($lines[$i], 0, $del_pos);
            $value = substr($lines[$i], $del_pos + 2);
            $headers[$name] = $value;
        }

        return array(
            'headers' => $headers,
            'html' => $body_part
        );
    }
}
