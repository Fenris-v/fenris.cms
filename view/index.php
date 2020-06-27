<?php

try {
    /** @noinspection PhpUndefinedVariableInspection */
    includeView('layout.header', ['title' => $title]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <section class="s_lastPublications pt-5">
        <div class="container">
            <div class="lastPublications row mb-2">
                <div class="col-md-6">
                    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static bg-yellow">
                            <strong class="d-inline-block mb-2 text-primary">World</strong>
                            <h3 class="mb-0 cyber">Featured post</h3>
                            <div class="mb-1 text-muted">Nov 12</div>
                            <p class="card-text mb-auto">This is a wider card with supporting text below as a natural
                                lead-in to additional content.</p>
                            <a href="#" class="stretched-link">Continue reading</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img src="/templates/images/logo.jpeg" alt="logo">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static bg-yellow">
                            <strong class="d-inline-block mb-2 text-success">Design</strong>
                            <h3 class="mb-0 cyber">Post title</h3>
                            <div class="mb-1 text-muted">Nov 11</div>
                            <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to
                                additional content.</p>
                            <a href="#" class="stretched-link">Continue reading</a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img src="/templates/images/logo.jpeg" alt="logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="s_list mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 blog-main">
                    <h3 class="pb-4 mb-4 cyber border-bottom">
                        From the Firehose
                    </h3>

                    <?php
                    try {
                        includeView('render.articleList');
                    } catch (Exception $exception) {
                        echo $exception->getMessage() . ' ' . $exception->getCode();
                    }
                    ?>

                    <nav class="blog-pagination">
                        <a class="btn btn-outline-primary" href="#">Older</a>
                        <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1"
                           aria-disabled="true">Newer</a>
                    </nav>

                </div>

                <aside class="col-md-4 blog-sidebar">
                    <div class="p-4 mb-3 bg-yellow rounded">
                        <h4 class="font-italic">About</h4>
                        <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur
                            purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    </div>

                    <div class="p-4">
                        <h4 class="font-italic">Archives</h4>
                        <ol class="list-unstyled mb-0">
                            <li><a href="#">March 2014</a></li>
                            <li><a href="#">February 2014</a></li>
                            <li><a href="#">January 2014</a></li>
                            <li><a href="#">December 2013</a></li>
                            <li><a href="#">November 2013</a></li>
                            <li><a href="#">October 2013</a></li>
                            <li><a href="#">September 2013</a></li>
                            <li><a href="#">August 2013</a></li>
                            <li><a href="#">July 2013</a></li>
                            <li><a href="#">June 2013</a></li>
                            <li><a href="#">May 2013</a></li>
                            <li><a href="#">April 2013</a></li>
                        </ol>
                    </div>

                    <div class="p-4">
                        <h4 class="font-italic">Elsewhere</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">GitHub</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                        </ol>
                    </div>
                </aside>

            </div>
        </div>
    </section>

<?php
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}
