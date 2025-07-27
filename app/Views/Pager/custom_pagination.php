<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Pagination" class="flex justify-center">
    <ul class="flex items-center space-x-1 bg-white rounded-lg shadow-sm border border-gray-200 p-1">
        <!-- First Page Link -->
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="First" 
                   class="flex items-center justify-center w-10 h-10 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-primary-50 hover:to-primary-100 hover:text-primary-700 hover:border-primary-300 transition-all duration-200">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="Previous" 
                   class="flex items-center justify-center w-10 h-10 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-primary-50 hover:to-primary-100 hover:text-primary-700 hover:border-primary-300 transition-all duration-200">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        <?php endif ?>

        <!-- Page Number Links -->
        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <?php if ($link['active']) : ?>
                    <span aria-current="page"
                       class="flex items-center justify-center w-10 h-10 text-sm text-white bg-gradient-to-r from-primary-600 to-primary-700 border border-primary-600 font-bold rounded-lg shadow-md cursor-default">
                        <?= $link['title'] ?>
                    </span>
                <?php else : ?>
                    <a href="<?= $link['uri'] ?>" aria-label="Page <?= $link['title'] ?>"
                       class="flex items-center justify-center w-10 h-10 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-primary-50 hover:to-primary-100 hover:text-primary-700 hover:border-primary-300 transition-all duration-200">
                        <?= $link['title'] ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>

        <!-- Next and Last Page Links -->
        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="Next" 
                   class="flex items-center justify-center w-10 h-10 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-primary-50 hover:to-primary-100 hover:text-primary-700 hover:border-primary-300 transition-all duration-200">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="Last" 
                   class="flex items-center justify-center w-10 h-10 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gradient-to-r hover:from-primary-50 hover:to-primary-100 hover:text-primary-700 hover:border-primary-300 transition-all duration-200">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav> 