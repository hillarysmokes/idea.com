<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $idea_id = $_POST['idea_id'];

    if ($action === 'approve') {
        $conn->query("UPDATE ideas SET approved = 1 WHERE id = $idea_id");
    } elseif ($action === 'deactivate') {
        $conn->query("UPDATE ideas SET approved = 0 WHERE id = $idea_id");
    } elseif ($action === 'edit') {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $timeframe = $_POST['timeframe'];
        $conn->query("UPDATE ideas SET title='$title', category='$category', description='$description', timeframe='$timeframe' WHERE id=$idea_id");
    }
}
$result = $conn->query("SELECT * FROM ideas");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Panel</h1>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Timeframe</th>
                    <th>Votes</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['timeframe']); ?></td>
                        <td><?php echo $row['votes']; ?></td>
                        <td><?php echo $row['approved'] ? 'Approved' : 'Deactivated'; ?></td>
                        <td>
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="idea_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="idea_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="deactivate" class="btn btn-warning btn-sm">Deactivate</button>
                            </form>
                            <button class="btn btn-primary btn-sm" onclick="openEditModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['title']); ?>', '<?php echo htmlspecialchars($row['category']); ?>', '<?php echo htmlspecialchars($row['description']); ?>', '<?php echo htmlspecialchars($row['timeframe']); ?>')">Edit</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Idea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idea_id" id="editIdeaId">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <input type="text" name="category" id="editCategory" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="editDescription" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Timeframe</label>
                        <input type="text" name="timeframe" id="editTimeframe" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="action" value="edit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, title, category, description, timeframe) {
            document.getElementById('editIdeaId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editCategory').value = category;
            document.getElementById('editDescription').value = description;
            document.getElementById('editTimeframe').value = timeframe;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
