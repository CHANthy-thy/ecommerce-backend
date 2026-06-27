# TODO - Admin Dashboard Redesign

- [ ] Implement dynamic dashboard statistics (controller): categories, brands, products, users, orders (pending/completed), stock counts (in/low/out), revenue (completed orders total sum)

- [x] Fetch dashboard datasets: recent 10 orders, latest 10 products, low stock products (stock <= 10)



- [x] Redesign `resources/views/admin/dashboard.blade.php` with professional e-commerce admin UI:
   - [x] responsive stat cards with icons
   - [x] recent orders table
   - [x] latest products table
   - [x] low stock products table with orange/red row highlights
   - [x] quick actions buttons

- [x] Ensure images show real URLs (fallback allowed only to existing placeholder image when missing)

- [ ] Future-ready data structure for easy charts addition
- [x] Final verification by running the dashboard and checking database-driven updates


