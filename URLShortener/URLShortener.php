<?php
// class Database {
//     private $conn;

//     public function __construct() {
//         try {
//             $this->conn = new PDO("mysql:host=127.0.0.1:3307;dbname=url_shortener", "root", "root");
//             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (PDOException $e) {
//             die("Ошибка подключения к базе данных: " . $e->getMessage());
//         }
//     }

//     public function createShortenedURL($originalURL) {
//         $shortenedURL = $this->generateUniqueShortenedURL();
        
//         $stmt = $this->conn->prepare("INSERT INTO shortened_urls (original_url, shortened_url) VALUES (:original_url, :shortened_url)");
//         $stmt->bindParam(":original_url", $originalURL);
//         $stmt->bindParam(":shortened_url", $shortenedURL);
//         $stmt->execute();

//         return $shortenedURL;
//     }

//     private function generateUniqueShortenedURL() {
//         do {
//             // $shortenedURL = 'click/' . substr(md5(uniqid()), 0, 8);
//             $randomBytes = random_bytes(4); // Генерируем 4 случайных байта
//             $shortenedURL = 'click/' . bin2hex($randomBytes);
            
//             $stmt = $this->conn->prepare("SELECT id FROM shortened_urls WHERE shortened_url = :shortened_url");
          
//             $stmt->bindParam(":shortened_url", $shortenedURL);
       
//             $stmt->execute();
//             $exists = $stmt->fetch(PDO::FETCH_ASSOC);
//         } while ($exists);

//         return $shortenedURL;
//     }

//     // public function getOriginalURL($shortenedURL) {
//     //     $stmt = $this->conn->prepare("SELECT original_url FROM shortened_urls WHERE shortened_url = :shortened_url");
//     //     $stmt->bindParam(":shortened_url", $shortenedURL);
//     //     $stmt->execute();

//     //     $result = $stmt->fetch(PDO::FETCH_ASSOC);

//     //     return $result ? $result['original_url'] : null;
//     // }

//     public function getOriginalURL($shortenedURL) {
//         try {
//             // Ищем исходную ссылку по короткой
//             $stmt = $this->conn->prepare("SELECT original_url FROM shortened_urls WHERE shortened_url = :shortened_url");
//             $stmt->bindParam(":shortened_url", $shortenedURL);
//             $stmt->execute();
    
//             $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
//             return $result ? $result['original_url'] : null;
//         } catch (PDOException $e) {
//             die("Ошибка при запросе к базе данных: " . $e->getMessage());
//         }
//     }
    
// }

// class URLShortener {
//     private $db;

//     public function __construct() {
//         $this->db = new Database();
//     }

//     public function shortenURL($originalURL) {
//         return $this->db->createShortenedURL($originalURL);
//     }

//     public function redirectToOriginalURL($originalURL) {
//         $originalURL = $this->db->getOriginalURL($originalURL);

//         if ($originalURL) {
//             header("Location: $originalURL");
//             exit;
//         } else {
//             echo "URL не найден.";
//         }
//     }
// }



class Database {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=127.0.0.1:3307;dbname=url_shortener", "root", "root");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    public function createShortenedURL($originalURL) {
        $shortenedURL = substr(md5(uniqid()), 0, 8);
        
        $stmt = $this->conn->prepare("INSERT INTO shortened_urls (original_url, shortened_url) VALUES (:original_url, :shortened_url)");
        $stmt->bindParam(":original_url", $originalURL);
        $stmt->bindParam(":shortened_url", $shortenedURL);
        $stmt->execute();

        return $shortenedURL;
    }

    public function getOriginalURL($shortenedURL) {
        $stmt = $this->conn->prepare("SELECT original_url FROM shortened_urls WHERE shortened_url = :shortened_url");
        $stmt->bindParam(":shortened_url", $shortenedURL);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['original_url'] : null;
    }
}

class URLShortener {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function shortenURL($originalURL) {
        return $this->db->createShortenedURL($originalURL);
    }

    public function redirectToOriginalURL($shortenedURL) {
        $originalURL = $this->db->getOriginalURL($shortenedURL);

        if ($originalURL) {
            header("Location: $originalURL");
            exit;
        } else {
            echo "URL не найден.";
        }
    }
}
?>

