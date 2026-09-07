<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lab Management Dashboard</title>
  
  <!-- FontAwesome for icons -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-pbO2plKhjoHYlqplCq7fA4k8L5HU8P/QuP+fOXGxUFXFq+Fv2c9XIoNj9RlVLflz8hbZkO3mV6OY7OxIUqWkeg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  
  <style>
    /* Reset */
    * {
      box-sizing: border-box;
    }
    body, html {
      margin: 0; padding: 0; height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f7fa;
      overflow: hidden;
    }
    a {
      text-decoration: none;
      color: inherit;
    }
    
    /* Layout */
    .dashboard {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }
    
    /* Sidebar */
    .sidebar {
      width: 250px;
      background: #2f4050;
      color: #fff;
      display: flex;
      flex-direction: column;
      transition: width 0.3s ease;
      position: relative;
      user-select: none;
    }
    .sidebar.collapsed {
      width: 70px;
    }
    
    .sidebar-header {
      padding: 20px;
      font-size: 1.6em;
      font-weight: bold;
      text-align: center;
      border-bottom: 1px solid #3c4a5a;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .nav-menu {
      flex-grow: 1;
      padding-top: 10px;
      overflow-y: auto;
    }
    .nav-menu ul {
      list-style: none;
      margin: 0; padding: 0;
    }
    .nav-menu li {
      display: flex;
      align-items: center;
      padding: 14px 25px;
      cursor: pointer;
      border-left: 4px solid transparent;
      transition: background 0.3s ease, border-color 0.3s ease;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .nav-menu li i {
      margin-right: 15px;
      min-width: 18px;
      text-align: center;
      font-size: 1.1em;
    }
    .sidebar.collapsed .nav-menu li i {
      margin-right: 0;
    }
    .sidebar.collapsed .nav-menu li span {
      display: none;
    }
    .nav-menu li:hover {
      background: #1abc9c;
      border-left-color: #16a085;
    }
    .nav-menu li.active {
      background: #16a085;
      border-left-color: #1abc9c;
      font-weight: 600;
    }
    
    /* Header */
    .header {
      height: 60px;
      background: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
      font-weight: 600;
      font-size: 1.2em;
      color: #2c3e50;
      flex-shrink: 0;
      user-select: none;
    }
    .header-left {
      display: flex;
      align-items: center;
    }
    .toggle-btn {
      font-size: 1.4em;
      color: #2c3e50;
      cursor: pointer;
      margin-right: 20px;
      user-select: none;
    }
    .header-title {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .logout-btn {
      cursor: pointer;
      font-size: 1em;
      color: #e74c3c;
      background: transparent;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .logout-btn:hover {
      background-color: #e74c3c;
      color: white;
    }
    
    /* Main content */
    .main-content {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    iframe {
      border: none;
      width: 100%;
      flex-grow: 1;
      background: white;
    }
    
    /* Scrollbar for sidebar menu */
    .nav-menu::-webkit-scrollbar {
      width: 6px;
    }
    .nav-menu::-webkit-scrollbar-track {
      background: #2f4050;
    }
    .nav-menu::-webkit-scrollbar-thumb {
      background: #1abc9c;
      border-radius: 3px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        height: 100%;
        z-index: 1000;
        left: 0;
        top: 0;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .sidebar.collapsed {
        width: 250px;
      }
      .main-content {
        margin-left: 0;
      }
      .toggle-btn {
        display: inline-block;
      }
    }
  </style>
</head>
<body>

<div class="dashboard">

  <nav class="sidebar" id="sidebar">
    <div class="sidebar-header" title="Lab Management Dashboard">
      Lab Dashboard
    </div>
    <div class="nav-menu" id="navMenu">
      <ul>
        <li class="active" data-src="lab_test_list.php" title="Manage Tests">
          <i class="fas fa-vials"></i><span>Manage Tests</span>
        </li>
        <li data-src="test_parameters.php" title="Master Parameters">
          <i class="fas fa-cogs"></i><span>Master Parameters</span>
        </li>
        <li data-src="users.php" title="Manage Users">
          <i class="fas fa-users"></i><span>Manage Users</span>
        </li>
        <li data-src="test_entry_list.php" title="Manage Test Result">
          <i class="fas fa-file-medical-alt"></i><span>Manage Test Result</span>
        </li>
        <li data-src="bill_add.php" title="Add Bill">
          <i class="fas fa-file-invoice-dollar"></i><span>Add Bill</span>
        </li>
        <li data-src="bill_list.php" title="Bill List">
          <i class="fas fa-list-alt"></i><span>Bill List</span>
        </li>
        <li data-src="sample_collection.php" title="Collect Samples">
          <i class="fas fa-flask"></i><span>Collect Samples</span>
        </li>
      </ul>
    </div>
  </nav>

  <div class="main-content">
    <header class="header">
      <div class="header-left">
        <i class="fas fa-bars toggle-btn" id="sidebarToggle" title="Toggle Menu"></i>
        <div class="header-title" id="pageTitle">Manage Tests</div>
      </div>
      <button class="logout-btn" id="logoutBtn">Logout</button>
    </header>
    
    <iframe src="lab_test_list.php" name="contentFrame" id="contentFrame"></iframe>
  </div>
</div>

<script>
  const sidebar = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('sidebarToggle');
  const menuItems = document.querySelectorAll('#navMenu li');
  const iframe = document.getElementById('contentFrame');
  const pageTitle = document.getElementById('pageTitle');
  const logoutBtn = document.getElementById('logoutBtn');

  // Toggle sidebar collapse
  toggleBtn.addEventListener('click', () => {
    if(window.innerWidth <= 768) {
      // On small screen, toggle show/hide sidebar
      sidebar.classList.toggle('show');
    } else {
      // On desktop, toggle collapsed width
      sidebar.classList.toggle('collapsed');
    }
  });

  // Menu click to load iframe src and highlight active
  menuItems.forEach(item => {
    item.addEventListener('click', () => {
      // Remove active class
      menuItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');

      // Load page in iframe
      const src = item.getAttribute('data-src');
      iframe.src = src;

      // Update header title
      pageTitle.textContent = item.textContent.trim();

      // On small screens, hide sidebar after selection
      if(window.innerWidth <= 768) {
        sidebar.classList.remove('show');
      }
    });
  });

  // Logout button placeholder - add your logout code here
  logoutBtn.addEventListener('click', () => {
    if(confirm('Are you sure you want to logout?')) {
      // Redirect to logout script or homepage
      window.location.href = 'logout.php';  // Change as needed
    }
  });

  // Optional: Update iframe title on iframe load (if needed)
  iframe.addEventListener('load', () => {
    // you can add additional logic here
  });
</script>

</body>
</html>
