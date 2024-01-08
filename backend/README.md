## SETUP

 1. Tạo mới file **.env**, copy nội dung **.env.example** sang và thay đổi giá trị ``DB_DATABASE`` thành database của mình
 2. Chạy ``composer install`` để cài đặt các package **composer**
 3. Chạy ``php artisan key:generate`` để sinh key cho ứng dụng
 4. Chạy ``php artisan migrate`` để tạo các bảng trong database
 5. Chạy ``php artisan db:seed`` để sinh dữ liệu cho database
 6. Chạy ``php artisan passport:install --force`` để tạo key cho **passport**
 7. Chạy ``php artisan l5-swagger:generate`` để tạo api document

## UPDATE
 1. Checkout branch ``develop`` và pull code mới nhất về
 2. Chạy ``composer dump-autoload`` để autoload các class mới
 3. Chạy ``php artisan migrate:refresh --seed`` để refresh lại database
 4. Chạy ``php artisan passport:install --force`` để tạo key cho **passport**
 5. Chạy ``php artisan l5-swagger:generate`` để tạo api document

## RUN

Chạy ``php artisan serve`` để khởi động serve
Truy cập ``/api/documentation`` để sử dụng api document
Run queue ``php artisan queue:work --queue=default``

## DEBUG

  1. Thông báo lỗi: ``Personal access client not found. Please create one.``
  > Giải pháp: Chạy ``php artisan passport:install --force``

  2. Thông báo lỗi: ``Unable to flush cache.`` (Laravel Permission)
  > Giải pháp: Chạy ``sudo php artisan cache:forget spatie.permission.cache && sudo php artisan cache:clear``

## CREATE MENU AND PERMISSION.
  1. Create Permission
  Khi tạo một feature api cần phải tạo permission để có thể truy cập vào api.
  **Lưu ý:**
  - Tạo seeder tương ứng(nếu chưa có)
  Cách tạo:
  ``php artisan make:seeder NameSeeder``

  B1: Xóa cache của permission.
  ```php
  app()[PermissionRegistrar::class]->forgetCachedPermissions();
  ```
  B2: Tạo mảng các action của api.
  **Example:**
  ```php
  $actions = ['index', 'store', 'show', 'update', 'destroy', 'getProfile', 'uploadFileLocal', 'uploadFileS3'];
  ```
  B3: Tạo permission.
  **Example:**
  ```php
  $prefix = strtolower(class_basename(User::class));

  foreach ($actions as $key) {
    Permission::create(['name' => $prefix . '.' . $key]);
  }
  ```
  B4: Chạy seeder vừa tạo và thêm seeder vừa tạo vào file ``DatabaseSeeder.php``
  - Run seeder: ``php artiasn db:seed --class=NameSeeder``
  - Thêm seeder vào file ``DatabaseSeeder.php``
  **Example:**
  ```php
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);

        $this->call(NameSeeder::class); // add to here

        $this->call(PermissionDataSeeder::class);
        $this->call(DataSeeder::class);
    }
  ```
  **Lưu ý:**
  Nếu set name route theo cấu trúc ``model.action`` thì sẽ giảm thời gian xử lý(recomemend)
  ```php
  Route::get('me', 'UserController@getProfile')->name('user.getProfile');
  ```

## USING ANH EXAMPLE.
  1. Các hàm thông dụng:
  > ```$this->repository->list($conditions, $relation, $relationCounts)``` lấy list và relation theo dữ liệu đầu vào.
   - ``$conditions``: mảng các điều kiện.
   - ``$relation``: mảng realtion cần trả về.
   - ``$relationCounts``: mảng realtion cần trả về số lượng.
   *Chú ý:*
   - Việc xử lý điều kiện truyền vào nằm trong hàm `search` của repository tương ứng.

  ```php
    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'type':
                return $query->where($column, $data);
            case 'name':
                return $query->whereRaw("concat(last_name, '', first_name) like '%$data%' ");
            case 'email':
            case 'username':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            default:
                return $query;
                break;
        }
    }
  ```
  **Lưu ý:**
  - Trong trường hợp cần phải custom sql thì có thể sử thêm whereRaw vào hàm ``search()`` trong repository như sau:
  ```php
    // UserService.php
    public function list($conditions, $relations = [], $relationCounts = []) {
      $conditions['raw'] = "`id` != 1";
      return $this->repository->list($conditions, $relations = [], $relationCounts = []);
    }

    // UserRepository.php
    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'type':
                return $query->where($column, $data);
            case 'name':
                return $query->whereRaw("concat(last_name, '', first_name) like '%$data%' ");
            case 'email':
            case 'username':
                return $query->where($column, 'like', '%' . $data . '%');
                break;
            case 'raw':
                return $query->whereRaw($data);
                break;
            default:
                return $query;
                break;
        }
    }
  ```
   - Relation:
   TH1:
    ```php
      $this->repository->list($conditions, ['roles'])
    ```
   TH2:
    ```php
      $this->repository->list($conditions, ['roles' => function ($query) use($data) {
        $query->where('name', 'admin');
      }]);
    ```
   TH3: lấy relation của relation
    ```php
       $this->repository->list($conditions, ['roles', 'menus.menus']);
    ```
    TH4: lấy relation của relation and custom
    ```php
       $this->repository->list($conditions, ['roles', 'menus.menus' => function ($query) use($data) {
         $query->where('name', 'user.index');
       }]);
    ```

  > ``$this->repository->findByCondition($conditions, $relations, $relationCounts)`` sử dụng để lấy danh theo condition nhưng ko trả về pagination mà trả về 1 collection.
    - ``$conditions``: mảng các điều kiện.
    - ``$relation``: mảng realtion cần trả về.
    - ``$relationCounts``: mảng realtion cần trả về số lượng.

  > ``$this->repository->create($data)`` sử dụng để tạo record.
   - ``$data``: mảng dữ liệu cần tạo.
   ``$this->repository->detail($user, $relations)``
      ``$user``: là instance of model cần update.
      ``$relation``: mảng realtion cần trả về.

  > ``$this->repository->update($user, $data)`` sử dụng dể update một record.
   - ``$user``: là instance of model cần update.
   - ``$data``: là mảng dữ các trường và dự liêu cần update

  > ``$this->repository->delete($user)`` Để xóa 1 record.
   - ``$user``: là instance of model cần xóa.

## coding convention
- Quy tắc đặt tên
    > (camelCase) `ký tự đầu tiên của từ đầu tiên viết thường những ký tự đầu tiên của những từ tiếp theo được viết hoa --> áp dụng cho: tên biến, tên hàm`\
    > (PascalCase) `cú pháp Pascal viết hoa chữ cái đầu tiên của mỗi từ --> áp dụng cho: tên lớp`\
    > (snake_case) `cú pháp con rắn, tất cả các chữ cái đều viết thường, và các từ cách nhau bởi dấu gạch dưới --> áp dụng cho: tên biến, tên hàm`

- Quy tắc số lượng
    > `Hàm không nên quá 30 dòng`\
    > `Lớp không nên vượt quá 500 dòng`\
    > `Một hàm không được vượt quá 5 tham số, nên giữ <=3`\
    > `Một hàm chỉ nên làm duy nhất 1 việc`\
    > `Khi khai báo biến, một dòng chỉ chứa một biến`\
    > `Một dòng không nên dài quá 80 ký tự`\
    > `Các câu lệnh lồng nhau tối đa 4 cấp`\

- Quy tắc xuống dòng
    > `Nếu có dấu phẩy thì xuống hàng sau dấu phẩy`\
    > `Nếu có nhiều cấp lồng nhau, thì xuống hàng theo từng cấp`\
    > `Dòng xuống hàng mới thì nên bắt đầu ở cùng cột với đoạn lệnh cùng cấp ở trên`\

- Quy tắc code PSR
<table>
<thead>
<tr>
<th>Mã</th>
<th>Tên</th>
<th>Miêu tả</th>
<th>Trạng thái</th>
</tr>
</thead>
<tbody>
<tr>
<td>PSR-0</td>
<td>Tiêu chuẩn tự động tải</td>
<td>Nó mô tả các yêu cầu bắt buộc phải được tuân thủ để có khả năng tương tác của trình tải tự động.</td>
<td>Từ 30-12-2014 PSR-0 được thay thế bởi PSR-4</td>
</tr>
<tr>
<td>PSR-1</td>
<td>Tiêu chuẩn code cơ bản</td>
<td>Nó bao gồm những gì nên được coi là các yếu tố code tiêu chuẩn được yêu cầu để đảm bảo mức độ tương tác kỹ thuật cao giữa code PHP được chia sẻ</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-2</td>
<td>Phong cách code</td>
<td>Nó xem xét PSR-1 và nó nhằm giảm ma sát nhận thức khi quét mã code từ các tác giả khác nhau. Nó làm như vậy bằng cách liệt kê một bộ quy tắc và kỳ vọng được chia sẻ về cách định dạng mã code PHP.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-3</td>
<td>Giao diện logger</td>
<td>Nó mô tả một giao diện chung cho các thư viện đăng nhập.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-4</td>
<td>Tiêu chuẩn tự động tải</td>
<td>Nó mô tả một đặc tả cho các lớp tự động tải từ các đường dẫn tệp. Nó hoàn toàn có thể tương tác và có thể được sử dụng cùng với bất kỳ thông số kỹ thuật tự động tải nào khác, bao gồm PSR-0. PSR này cũng mô tả nơi đặt các tệp sẽ được tải tự động theo đặc điểm kỹ thuật.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-5</td>
<td>Tiêu chuẩn PHPDoc</td>
<td>Mục đích chính của PSR này là cung cấp một định nghĩa đầy đủ và chính thức về tiêu chuẩn PHPDoc. PSR này khác với tiền thân của nó, Tiêu chuẩn PHPDoc thực tế liên quan đến phpDocumentor 1.x, để cung cấp hỗ trợ cho các tính năng mới hơn trong ngôn ngữ PHP và để giải quyết một số thiếu sót của người tiền nhiệm.</td>
<td>Dự thảo</td>
</tr>
<tr>
<td>PSR-6</td>
<td>Giao diện bộ nhớ đệm</td>
<td>Mục tiêu của PSR này là cho phép các nhà phát triển tạo các thư viện nhận biết bộ đệm có thể được tích hợp vào các khung và hệ thống hiện có mà không cần phát triển tùy chỉnh.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-7</td>
<td>Giao diện tin nhắn HTTP</td>
<td>Nó mô tả các giao diện phổ biến để biểu diễn các thông điệp HTTP như được mô tả trong RFC 7230 và RFC 7231 và URI để sử dụng với các thông điệp HTTP như được mô tả trong RFC 3986.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-8</td>
<td>Giao diện có thể chạy được</td>
<td>Nó thiết lập một cách chung cho các đối tượng thể hiện sự đánh giá và hỗ trợ lẫn nhau bằng cách siết chặt. Điều này cho phép các đối tượng hỗ trợ lẫn nhau theo cách xây dựng, tăng cường hợp tác giữa các dự án PHP khác nhau.</td>
<td>Bị bỏ rơi</td>
</tr>
<tr>
<td>PSR-9</td>
<td>Công khai an ninh</td>
<td>Nó mang lại cho dự án một cách tiếp cận được xác định rõ ràng để cho phép người dùng cuối khám phá các tiết lộ bảo mật bằng cách sử dụng định dạng có cấu trúc được xác định rõ ràng cho các tiết lộ này.</td>
<td>Bị bỏ rơi</td>
</tr>
<tr>
<td>PSR-10</td>
<td>Tư vấn bảo mật</td>
<td>Nó cung cấp cho các nhà nghiên cứu, lãnh đạo dự án, lãnh đạo dự án thượng nguồn và người dùng cuối một quy trình được xác định và có cấu trúc để tiết lộ các lỗ hổng bảo mật</td>
<td>Bị bỏ rơi</td>
</tr>
<tr>
<td>PSR-11</td>
<td>Giao diện container</td>
<td>Nó mô tả một giao diện chung cho các container phụ thuộc. Mục tiêu là để chuẩn hóa cách các khung và thư viện sử dụng một container để thu được các đối tượng và tham số (được gọi là các mục trong phần còn lại của tài liệu này).</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-12</td>
<td>Hướng dẫn kiểu mã hóa mở rộng</td>
<td>Nó mở rộng, mở rộng và thay thế PSR-2, hướng dẫn kiểu mã hóa và yêu cầu tuân thủ PSR-1, tiêu chuẩn mã hóa cơ bản.</td>
<td>Dự thảo</td>
</tr>
<tr>
<td>PSR-13</td>
<td>Liên kết Hypermedia</td>
<td>Nó mô tả các giao diện phổ biến để đại diện cho một liên kết hypermedia.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-14</td>
<td>Quản lý sự kiện</td>
<td>Nó mô tả các giao diện phổ biến để gửi và xử lý các sự kiện.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-15</td>
<td>Trình xử lý yêu cầu máy chủ HTTP</td>
<td>Nó mô tả các giao diện phổ biến cho các trình xử lý yêu cầu máy chủ HTTP và các thành phần phần mềm trung gian của máy chủ HTTP sử dụng các thông điệp HTTP.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-16</td>
<td>Bộ nhớ cache đơn giản</td>
<td>Nó mô tả một giao diện đơn giản nhưng có thể mở rộng cho một mục bộ đệm và trình điều khiển bộ đệm.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-17</td>
<td>HTTP Factories</td>
<td>Nó mô tả một tiêu chuẩn chung cho các nhà máy tạo ra các đối tượng HTTP tuân thủ PSR-7.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-18</td>
<td>Máy khách HTTP</td>
<td>Nó mô tả một giao diện chung để gửi các yêu cầu HTTP và nhận phản hồi HTTP.</td>
<td>Được chấp nhận</td>
</tr>
<tr>
<td>PSR-19</td>
<td>Thẻ PHPDoc</td>
<td>Nó cung cấp một danh mục đầy đủ các thẻ trong tiêu chuẩn PHPDoc .</td>
<td>Dự thảo</td>
</tr>
</tbody>
</table>
