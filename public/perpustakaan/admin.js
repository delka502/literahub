  // Toggle sidebar on mobile
  document.querySelector('.navbar-toggler').addEventListener('click', function() {
    document.querySelector('.sidebar').classList.toggle('d-none');
});

// Add active class to current menu item
document.addEventListener('DOMContentLoaded', function() {
    const currentLocation = location.href;
    const menuItems = document.querySelectorAll('.sidebar-menu a');
    menuItems.forEach(item => {
        if(item.href === currentLocation) {
            item.classList.add('active');
        }
    });
});