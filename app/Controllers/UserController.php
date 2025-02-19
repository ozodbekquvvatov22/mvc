<?php
require_once '../core/Controller.php';
require_once '../app/Models/User.php';
class UserController extends Controller
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function register()
    {
        $this->view('auth/register');
    }
    
    public function login()
    {

        $this->view('auth/login');
    }
    public function store()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if ($this->userModel->exists($email)) {
                echo "<p style='color: red; font-size: 18px;'>Bu email allaqachon ishlatilgan! Iltimos, login qiling.<br> <a href='/auth/login'>Login</a></p>";
                return;
            }

            $id = $this->userModel->create($name, $email, $password);

            if ($id) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_email'] = $email;
                header("Location: /post/index");
                exit();
            } else {
                echo "<p style='color: red;'>Xatolik: Foydalanuvchi yaratilmagan!<br><a href='/post/register'>Register</a></p>";
            }
        }
    }
    public function Loginstore()
    {
        // session_start(); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->findByEmail($email);

            if (!$user) {
                echo "<p style='color: red;'>Bunday email mavjud emas! Iltimos, registratsiya qiling<br><a href='/auth/register'>Register</a>.</p>";
                return;
            }

            if (!password_verify($password, $user['password'])) {
                echo "<p style='color: red;'>Parol noto‘g‘ri! Qaytadan urinib ko‘ring<br><a href='/auth/login'>Login</a>.</p>";
                return;
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: /post/index");
            exit();
        }
    }
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /auth/register");
        exit();
    }
}
