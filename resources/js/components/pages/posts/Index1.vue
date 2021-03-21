<nav aria-label="Page navigation example">
  <ul class="pagination">
      
    <li :class="{ disabled: !pagination.prev_page_url}"
        @click.prevent="getPosts(pagination.prev_page_url)"
        class="page-item">
        <a class="page-link" href="#">Назад</a>
    </li>
    
    <li @click.prevent="" class="page-item">
        <a class="page-link" href="">
            Страница {{ pagination.current_page }} из {{ pagination.last_page }}
        </a>
    </li>
    
    <li :class="{ disabled: !pagination.next_page_url}"
        @click.prevent="getPosts(pagination.next_page_url)"
         class="page-item">
        <a class="page-link" href="#">Вперед</a>
    </li>
    
  </ul>
</nav>