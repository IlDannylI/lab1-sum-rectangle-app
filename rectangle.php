<?php
$studentName = "Danny Munoz";
$currentDate = date("l, F j, Y");
$output = null;
$error = null;
$length = "";
$width = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $length = trim($_POST["length"] ?? "");
    $width  = trim($_POST["width"] ?? "");

    if (!is_numeric($length) || !is_numeric($width)) {
        $error = "Enter two valid numbers.";
    } elseif ($length <= 0 || $width <= 0) {
        $error = "Length and width must be greater than zero.";
    } else {
        $script  = escapeshellarg(__DIR__ . "/rectangle.py");
        $command = "python3 $script " . escapeshellarg($length) . " " . escapeshellarg($width);
        $output  = shell_exec($command);
        if ($output === null) {
            $error = "The Python script did not return a result.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Rectangle Calculator | <?= htmlspecialchars($studentName) ?></title>
<style>
  :root {
    --paper: #eef1f5;
    --ink: #14213d;
    --muted: #5b6577;
    --accent: #e07a1f;
    --card: #ffffff;
    --line: #d5dbe5;
    --ok: #1f7a4d;
    --bad: #b3261e;
  }
  @media (prefers-color-scheme: dark) {
    :root {
      --paper: #0f1626;
      --ink: #eef1f7;
      --muted: #9aa5ba;
      --card: #18223a;
      --line: #2b3855;
    }
  }
  * { box-sizing: border-box; }
  body {
    margin: 0;
    min-height: 100vh;
    display: grid;
    place-items: center;
    padding: 24px;
    background: var(--paper);
    color: var(--ink);
    font-family: "Segoe UI", system-ui, -apple-system, Helvetica, Arial, sans-serif;
  }
  .card {
    width: 100%;
    max-width: 460px;
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 14px;
    padding: 32px 28px 24px;
    box-shadow: 0 10px 30px rgba(20, 33, 61, 0.12);
  }
  .lab { margin: 0 0 18px; font-size: 1rem; font-weight: 600; color: var(--accent); }
  h1 {
    margin: 0 0 6px;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 1.9rem;
    letter-spacing: -0.5px;
  }
  .sub { margin: 0 0 24px; color: var(--muted); font-size: 0.95rem; line-height: 1.45; }
  .field + .field { margin-top: 14px; }
  label { display: block; font-size: 0.85rem; color: var(--muted); margin-bottom: 4px; }
  input[type="number"] {
    width: 100%;
    padding: 12px 14px;
    font-size: 1.2rem;
    font-family: Georgia, serif;
    color: var(--ink);
    background: transparent;
    border: 1px solid var(--line);
    border-radius: 8px;
  }
  input[type="number"]:focus-visible,
  button:focus-visible { outline: 3px solid var(--accent); outline-offset: 2px; }
  button {
    width: 100%;
    margin-top: 22px;
    padding: 13px;
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    background: var(--accent);
    border: 0;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.1s ease, filter 0.15s ease;
  }
  button:hover { filter: brightness(1.08); }
  button:active { transform: translateY(1px); }
  .result {
    margin-top: 22px;
    padding: 16px;
    border-left: 4px solid var(--ok);
    background: rgba(31, 122, 77, 0.1);
    border-radius: 6px;
  }
  .result strong { display: block; font-size: 0.85rem; color: var(--muted); margin-bottom: 6px; font-weight: 600; }
  .result p { margin: 0; font-family: Georgia, serif; font-size: 1.1rem; line-height: 1.6; }
  .error {
    margin-top: 22px;
    padding: 14px 16px;
    border-left: 4px solid var(--bad);
    background: rgba(179, 38, 30, 0.1);
    border-radius: 6px;
    color: var(--bad);
  }
  footer {
    margin-top: 26px;
    padding-top: 14px;
    border-top: 1px solid var(--line);
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 6px;
    font-size: 0.85rem;
    color: var(--muted);
  }
  footer .name { color: var(--ink); font-weight: 600; }
</style>
</head>
<body>
  <main class="card">
    <p class="lab">Lab #1 Software Installation</p>
    <h1>Rectangle calculator</h1>
    <p class="sub">
      Finds the area (length &times; width) and the perimeter (2 &times; (length + width))
      of a rectangle. The math runs in a Python script.
    </p>

    <form method="POST" action="">
      <div class="field">
        <label for="length">Length</label>
        <input type="number" step="any" min="0" id="length" name="length" value="<?= htmlspecialchars($length) ?>" required>
      </div>
      <div class="field">
        <label for="width">Width</label>
        <input type="number" step="any" min="0" id="width" name="width" value="<?= htmlspecialchars($width) ?>" required>
      </div>
      <button type="submit" name="submit">Calculate area and perimeter</button>
    </form>

    <?php if ($error): ?>
      <div class="error" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($output !== null): ?>
      <div class="result">
        <strong>Result from Python</strong>
        <p><?= nl2br(htmlspecialchars(trim($output))) ?></p>
      </div>
    <?php endif; ?>

    <footer>
      <span class="name">Author: <?= htmlspecialchars($studentName) ?></span>
      <span><?= htmlspecialchars($currentDate) ?></span>
    </footer>
  </main>
</body>
</html>
