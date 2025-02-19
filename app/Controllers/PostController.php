<?php
require_once '../app/Models/Post.php';
require_once '../core/Controller.php';
class PostController extends Controller
{
    private $postModel;
    public function __construct()
    {
        $this->postModel = new Post();
    }
    public function index()
    {
        if(!isset($_SESSION['user_email'])){
            header("Location: /auth/login");
            exit();
        }
        
        $posts = $this->postModel->all();
        $this->view('/post/index', ['posts' => $posts]);
    }
    public function create()
    {
        $this->view('post/create');
    }
    public function store()
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $this->postModel->create($title, $content);
        header("Location: /post/index");
    }   

    public function show()
    {
        $id = $_GET['id'];
        $post = $this->postModel->find($id);
        $this->view('post/show', ['post' => $post]);
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                echo "ID mavjud emas!";
                return;
            }
    
            $id = intval($_GET['id']); // Xavfsiz integer formatga o'tkazish
            
    }
    
    public function edit()
    {
        $id = $_GET['id'];
        $post = $this->postModel->find($id);
        $this->view('post/edit', ['post' => $post]);
    }
    public function update()
    {
        $id = $_GET['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $this->postModel->update($id, $title, $content);
        header("Location: /post/index");
    }

    public function destroy()
    {
        $id = $_GET['id'];
        $this->postModel->delete($id);
        header("Location: /post/index");
    }
}
