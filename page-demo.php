<?php
/**
 * Template Name: Demo Page
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="container">
    <div class="row">
        <?php if (is_active_sidebar('sidebar-left')): ?>
            <div class="col-12 col-md-3">
                <?php get_sidebar('left'); ?>
            </div>
        <?php endif; ?>

        <main class="site-main col">
            <h1>Demo Page</h1>
            <p>This page demonstrates the theme's default styles and shortcodes.</p>

            <hr>

            <h2>Theme Shortcodes</h2>

            <h3>Main Logo</h3>
            <p><code>[main_logo]</code></p>
            <?php echo do_shortcode('[main_logo]'); ?>
            <p><code>[main_logo size="thumbnail"]</code></p>
            <?php echo do_shortcode('[main_logo size="thumbnail"]'); ?>

            <h3>Second Logo</h3>
            <p><code>[second_logo]</code></p>
            <?php echo do_shortcode('[second_logo]'); ?>

            <h3>Phones</h3>
            <div class="row">
                <div class="col-md-4">
                    <h4>List (Default)</h4>
                    <p><code>[phones]</code></p>
                    <?php echo do_shortcode('[phones]'); ?>
                </div>
                <div class="col-md-4">
                    <h4>Column</h4>
                    <p><code>[phones format="column"]</code></p>
                    <?php echo do_shortcode('[phones format="column"]'); ?>
                </div>
                <div class="col-md-4">
                    <h4>Dropdown</h4>
                    <p><code>[phones format="dropdown"]</code></p>
                    <?php echo do_shortcode('[phones format="dropdown"]'); ?>
                </div>
            </div>

            <h3>Social Links</h3>
            <p><code>[social]</code></p>
            <?php echo do_shortcode('[social]'); ?>

            <h3>Messengers</h3>
            <p><code>[messengers]</code></p>
            <?php echo do_shortcode('[messengers]'); ?>

            <hr>

            <!-- HTML Demo Content -->
            <!-- Headings -->
            <h1>Heading 1 (h1)</h1>
            <h2>Heading 2 (h2)</h2>
            <h3>Heading 3 (h3)</h3>
            <h4>Heading 4 (h4)</h4>
            <h5>Heading 5 (h5)</h5>
            <h6>Heading 6 (h6)</h6>

            <hr>

            <!-- Paragraphs & Typography -->
            <h2>Typography</h2>
            <p class="lead">This is a lead paragraph. It stands out from regular text.</p>
            <p>This is a standard paragraph. Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Strong
                    text</strong>, <em>emphasized text</em>, <a href="#">inline link</a>, <mark>highlighted text</mark>,
                <code>inline code</code>, <small>small text</small>, <sub>subscript</sub>, and <sup>superscript</sup>.
            </p>
            <blockquote>
                <p>This is a blockquote. Use it for quoting external sources or highlighting important text.</p>
                <cite>— Citation Source</cite>
            </blockquote>
            <pre><code>
// This is a code block
function helloWorld() {

}
        </code></pre>

            <hr>

            <!-- Lists -->
            <h2>Lists</h2>
            <div class="row">
                <div class="col-md-6">
                    <h3>Unordered List</h3>
                    <ul>
                        <li>List item one</li>
                        <li>List item two
                            <ul>
                                <li>Nested list item A</li>
                                <li>Nested list item B</li>
                            </ul>
                        </li>
                        <li>List item three</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Ordered List</h3>
                    <ol>
                        <li>First item</li>
                        <li>Second item
                            <ol>
                                <li>Nested ordered item A</li>
                                <li>Nested ordered item B</li>
                            </ol>
                        </li>
                        <li>Third item</li>
                    </ol>
                </div>
            </div>
            <h3>Definition List</h3>
            <dl>
                <dt>Definition List Title</dt>
                <dd>This is a definition list division.</dd>
                <dt>Another Term</dt>
                <dd>And its definition.</dd>
            </dl>

            <hr>

            <!-- Tables -->
            <h2>Tables</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>

            <hr>

            <!-- Forms -->
            <h2>Forms</h2>
            <form>
                <fieldset>
                    <legend>Form Legend</legend>

                    <div class="mb-3">
                        <label for="TextInput">Text Input</label>
                        <input type="text" id="TextInput" placeholder="Placeholder text">
                    </div>

                    <div class="mb-3">
                        <label for="EmailInput">Email Input</label>
                        <input type="email" id="EmailInput" placeholder="name@example.com">
                    </div>

                    <div class="mb-3">
                        <label for="PasswordInput">Password</label>
                        <input type="password" id="PasswordInput" value="password123">
                    </div>

                    <div class="mb-3">
                        <label for="NumberInput">Number Input</label>
                        <input type="number" id="NumberInput" placeholder="42">
                    </div>

                    <div class="mb-3">
                        <label for="SelectInput">Select Menu</label>
                        <select id="SelectInput">
                            <option>Option 1</option>
                            <option>Option 2</option>
                            <option>Option 3</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Textarea">Textarea</label>
                        <textarea id="Textarea" rows="3" placeholder="Enter your message..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Checkboxes</label>
                        <div>
                            <input type="checkbox" id="check1" checked>
                            <label for="check1">Checked checkbox</label>
                        </div>
                        <div>
                            <input type="checkbox" id="check2">
                            <label for="check2">Unchecked checkbox</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Radio Buttons</label>
                        <div>
                            <input type="radio" name="radio" id="radio1" checked>
                            <label for="radio1">Radio option 1</label>
                        </div>
                        <div>
                            <input type="radio" name="radio" id="radio2">
                            <label for="radio2">Radio option 2</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="FileInput">File Input</label>
                        <input type="file" id="FileInput">
                    </div>

                    <div class="mb-3">
                        <label for="RangeInput">Range Input</label>
                        <input type="range" id="RangeInput">
                    </div>

                </fieldset>

                <div class="mt-3">
                    <button type="button">Regular Button</button>
                    <button type="submit">Submit Button</button>
                    <input type="submit" value="Input Submit">
                    <input type="reset" value="Input Reset">
                    <button type="button" disabled>Disabled Button</button>
                </div>
            </form>

            <hr>

            <!-- Buttons -->
            <h2>Button Variants</h2>

            <h3>Filled Buttons</h3>
            <p>
                <button class="btn btn-primary btn-sm">Small Button</button>
                <button class="btn btn-primary">Normal Button</button>
                <button class="btn btn-primary btn-lg">Large Button</button>
            </p>
            <p>
                <button class="btn btn-secondary btn-sm">Small Secondary</button>
                <button class="btn btn-secondary">Normal Secondary</button>
                <button class="btn btn-secondary btn-lg">Large Secondary</button>
            </p>
            <p>
                <button class="btn btn-accent btn-sm">Small Accent</button>
                <button class="btn btn-accent">Normal Accent</button>
                <button class="btn btn-accent btn-lg">Large Accent</button>
            </p>

            <h3>Outline Buttons</h3>
            <p>
                <button class="btn btn-outline-primary btn-sm">Small Outline</button>
                <button class="btn btn-outline-primary">Normal Outline</button>
                <button class="btn btn-outline-primary btn-lg">Large Outline</button>
            </p>
            <p>
                <button class="btn btn-outline-secondary btn-sm">Small Secondary Outline</button>
                <button class="btn btn-outline-secondary">Normal Secondary Outline</button>
                <button class="btn btn-outline-secondary btn-lg">Large Secondary Outline</button>
            </p>
            <p>
                <button class="btn btn-outline-accent btn-sm">Small Accent Outline</button>
                <button class="btn btn-outline-accent">Normal Accent Outline</button>
                <button class="btn btn-outline-accent btn-lg">Large Accent Outline</button>
            </p>

            <h3>Shine Effect (Attention Seeker)</h3>
            <p>
                <button class="btn btn-primary btn-shine">Shine Effect</button>
                <a href="#" class="btn btn-primary btn-lg btn-shine">Link with Shine</a>
            </p>
            <p>
                <button class="btn btn-secondary btn-shine">Secondary Shine</button>
                <a href="#" class="btn btn-secondary btn-lg btn-shine">Secondary Link Shine</a>
            </p>
            <p>
                <button class="btn btn-accent btn-shine">Accent Shine</button>
                <a href="#" class="btn btn-accent btn-lg btn-shine">Accent Link Shine</a>
            </p>

            <h3>Link as Button</h3>
            <p>
                <a href="#" class="btn btn-primary">Link Button</a>
                <a href="#" class="btn btn-outline-primary">Link Outline</a>
            </p>

            <hr>

            <!-- Details / Summary -->
            <h2>Details / Summary</h2>
            <details>
                <summary>Click to leverage details</summary>
                <p>Here are the details that were hidden.</p>
            </details>


            <?php
	while (have_posts()):
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			</header>
			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__('Pages:', 'brainworks'),
						'after' => '</div>',
					)
				);
				?>
			</div>
		</article>
		<?php
	endwhile;
	?>



        </main>

        <?php if (is_active_sidebar('sidebar-right')): ?>
            <div class="col-12 col-md-3">
                <?php get_sidebar('right'); ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
