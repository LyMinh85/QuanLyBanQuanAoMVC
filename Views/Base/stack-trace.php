<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1 class="">Fatal error</h1>
        </div>
        <div class="card-body">
            <p class="fs-5 card-title">
                Uncaught exception: 
                <span class="text-danger">'<?php echo $classException ?>'</span>
            </p>
            <p class="fs-5 card-text">Message:
                <span class="text-danger">'<?php echo $message ?>'</span>
            </p>
            <div>
                <p class="fw-bold">Stack trace:
                    <?php foreach ($stackTrace as $trace) : ?>
                <p class="font-monospace"><?php echo $trace ?></p>
            <?php endforeach; ?>
            </div>
        </div>
        <div class="card-footer">
            <h5>Thrown in
                <a class="link-primary" href="vscode://file/<?php echo $fileException ?>:<?php echo $lineException ?>">
                    <?php echo $fileException ?>:<?php echo $lineException ?>
                </a>
                on line <?php echo $lineException ?>
            </h5>
        </div>
    </div>

</div>