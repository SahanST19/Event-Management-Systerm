<?php include_once 'header.php'; ?>
<style>
  /* Background Image */
  body {
    margin: 0;
    padding: 0;
    background-image: url('uploads/images-home.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
  }

  .center-content {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;   /* 🔹 ihalata align wenne */
    align-items: flex-start;       /* 🔹 wamata align wenne */
    text-align: left;
    height: 100vh;
    padding-left: clamp(16px, 6vw, 120px);
    padding-top: 60px;             
    gap: 6px;
    color: #fff;
    background-color: rgba(12, 11, 11, 0.45);
  }

  .center-content h1 {
    margin: 0;
    padding: 0;
    font-size: clamp(30px, 4vw, 48px);
    line-height: 1.1;
    font-weight: 800;
  }
</style>

<div class="center-content">
  <h1>Hello</h1>
  <h1>Welcome to</h1>
  <h1>ST Event Management</h1>
</div>

<?php include_once 'footer.php'; ?>
