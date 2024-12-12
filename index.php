<?php include 'db_config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Idea Sharing Platform</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: #ffffff;
        }
        .card {
            background-color: #1e1e1e;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .card .btn {
            background-color: #007bff;
            border: none;
        }
        .form-section {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
        }
        .signature-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            border-radius: 8px;
            background-color: #1e1e1e;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="text-center">Idea Sharing Platform</h1>
        </div>
    </header>

    <main class="container mt-4">
        <div class="row">
            <!-- Idea Submission Form -->
            <section class="col-md-6 form-section mb-4">
                <h2 class="mb-3">Submit Your Idea</h2>
                <form action="submit_idea.php" method="POST" class="row g-3">
                    <div class="col-md-12">
                        <input type="text" name="title" class="form-control" placeholder="Idea Title" required>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="category" class="form-control" placeholder="Category" required>
                    </div>
                    <div class="col-12">
                        <textarea name="description" class="form-control" placeholder="Idea Description" rows="4" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="timeframe" class="form-control" placeholder="Timeframe" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Submit Idea</button>
                    </div>
                </form>
            </section>

            <!-- Signature Section -->
            <section class="col-md-6 signature-section mb-4">
                <h2 class="text-center">Your Signature Here</h2>
            </section>
        </div>

        <!-- List of Ideas -->
        <section>
            <h2 class="mb-3">Ideas</h2>
            <div class="d-flex overflow-auto" style="gap: 1rem;">
                <?php
                $result = $conn->query("SELECT * FROM ideas ORDER BY votes DESC, created_at DESC");
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <div class="card" style="min-width: 300px;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Category: <?php echo htmlspecialchars($row['category']); ?></h6>
                            <p class="card-text">Timeframe: <?php echo htmlspecialchars($row['timeframe']); ?></p>
                            <p class="card-text">Votes: <?php echo $row['votes']; ?></p>
                            <p class="card-text">Description: <?php echo htmlspecialchars($row['description']); ?></p>
                            <button class="btn btn-success upvote-btn" data-id="<?php echo $row['id']; ?>">Upvote</button>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                    <p>No ideas submitted yet!</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>