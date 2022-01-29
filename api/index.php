<?php
require_once(__DIR__.'/../core/db_config.php');
header('Access-Control-Allow-Origin: *'); #cors

class Api {
    private $db = null;

    public function __construct() {
        global $db;

        // authentication
        // user: lulububu
        // pw: qYgenu*rJPo_WVuuQDUr2R

        if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
            if ($_SERVER['PHP_AUTH_USER'] !== 'lulububu') {
                http_response_code(403);
                die(json_encode([
                    'status' => 'error',
                    'msg' => 'auth_failed_username'
                ]));
            } elseif ($_SERVER['PHP_AUTH_PW'] !== 'qYgenu*rJPo_WVuuQDUr2R') {
                http_response_code(403);
                die(json_encode([
                    'status' => 'error',
                    'msg' => 'auth_failed_password'
                ]));
            }
        } else {
            http_response_code(403);
            die(json_encode([
                'status' => 'error',
                'msg' => 'auth_missing'
            ]));
        }

        // all good, init
        $this->db = $db;
    }

    /**
     * @param array $data
     * @return bool
     * Adds a color to DB based on its $data
     */
    public function add_color(array $data):array {
        if (!isset($data['name'], $data['r'], $data['g'], $data['b'])) {
            http_response_code(400);
            die(json_encode([
                'status' => 'error',
                'msg' => 'data_fields_missing',
                'scope' => 'add_color'
            ]));
        }

        if (($data['r'] < 0 || $data['r'] > 255) || ($data['g'] < 0 || $data['g'] > 255) || ($data['b'] < 0 || $data['b'] > 255)) {
            http_response_code(400);
            die(json_encode([
                'status' => 'error',
                'msg' => 'data_field_validation_error',
                'scope' => 'add_color'
            ]));
        }

        // validation passed, insert
        $this->db->query("INSERT INTO colors SET 
            name = '".$this->db->real_escape_string($data['name'])."', 
            r = '".$this->db->real_escape_string($data['r'])."', 
            g = '".$this->db->real_escape_string($data['g'])."',
            b = '".$this->db->real_escape_string($data['b'])."'
        ");
        return [
            'status' => 'success',
            'inserted_id' => $this->db->insert_id
        ];

    }

    /**
     * @param int $id
     * @return bool
     * Deletes a color by $id
     */
    public function delete_color(int $id):array {
        $this->db->query("DELETE FROM colors WHERE id='".$this->db->real_escape_string($id)."'");
        return [
            'status' => 'success',
            'affected_rows' => $this->db->affected_rows
        ];
    }

    /**
     * @return string
     * Retrieves all colors
     */
    public function get():array {
        // best practice: limit this query to n rows
        // not done here since it's a challenge and the task was "get ALL colors"

        $colors = $this->db->query("SELECT * FROM colors ORDER BY savedate DESC");
        return $colors->fetch_all(MYSQLI_ASSOC);
    }
}

// handle requests
$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['scope'])) {
    // the scope in post request is set, lets check if everything we need is in the request

    $api = new Api();
    switch ($_POST['scope']) {

        case "add_color":
            if (isset($_POST['data'])) {
                die(json_encode($api->add_color($_POST['data'])));
            } else {
                http_response_code(400);
                die(json_encode([
                    'status' => 'error',
                    'msg' => 'data_postfield_missing',
                    'scope' => 'add_color'
                ]));
            }

        case "delete_color":
            if (isset($_POST['id'])) {
                die(json_encode($api->delete_color($_POST['id'])));
            } else {
                http_response_code(400);
                die(json_encode([
                    'status' => 'error',
                    'msg' => 'id_postfield_missing',
                    'scope' => 'delete_color'
                ]));
            }

        case "get":
            $request = $api->get();
            die(json_encode($api->get()));

        default:
            http_response_code(400);
            die(json_encode([
                'status' => 'error',
                'msg' => 'incorrect_scope'
            ]));
    }
}