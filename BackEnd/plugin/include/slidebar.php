


<style>
  .nav-link.active {
  background-color: #007bff; /* Màu xanh mặc định */
  color: #fff; /* Màu văn bản trắng */
}
</style>

<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-100" style="width: 280dp;">
    <a href="./index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4">Food</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li >
        <a href="index.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#"></use></svg>
          Sản Phẩm
        </a>
      </li>
      
      <li class="nav-item dropdown">
        <a href="#" class="nav-link text-white dropdown-toggle" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
          Tài Khoản
        </a>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="accountDropdown">
        <li><a class="dropdown-item" href="./page_users.php">Khách hàng</a></li>
        <li><a class="dropdown-item" href="./page_employee.php">Nhân Viên</a></li>

        </ul>
      </li>

      <li >
        <a href="./page_order.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#"></use></svg>
          Đơn hàng
        </a>
      </li>
      <li>
        <a href="./page_sale.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
          Doanh thu
        </a>
      </li>
      <li>
        <a href="./product_reviews.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
          Đánh Giá
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong>le cao ha</strong> <!-- Display the name from the session -->
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <!-- <li><a class="dropdown-item" href="#">New project...</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><a class="dropdown-item" href="#">Profile</a></li> -->
        <!-- <li><hr class="dropdown-divider"></li> -->
        <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
      </ul>
    </div>
  </div>
<script>
  // Lấy tất cả các mục nav-link
const navLinks = document.querySelectorAll('.nav-link');

// Lặp qua từng mục và thêm sự kiện click
navLinks.forEach(navLink => {
  navLink.addEventListener('click', function () {
    // Loại bỏ lớp active từ tất cả các mục nav-link
    navLinks.forEach(link => link.classList.remove('active'));
    
    // Thêm lớp active cho mục đã chọn
    this.classList.add('active');
    
    // Lưu trạng thái đã chọn vào sessionStorage
    sessionStorage.setItem('selectedNavItem', this.getAttribute('href'));
  });
});

// Kiểm tra nếu có trạng thái đã chọn trong sessionStorage và áp dụng nó
const selectedNavItem = sessionStorage.getItem('selectedNavItem');
if (selectedNavItem) {
  const selectedLink = document.querySelector(`a[href="${selectedNavItem}"]`);
  if (selectedLink) {
    selectedLink.classList.add('active');
  }
}

</script>
  