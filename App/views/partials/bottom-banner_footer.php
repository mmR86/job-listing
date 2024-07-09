<?php

use Framework\Session;

?>

<!-- Bottom Banner -->
      <section class="container mx-auto my-6">
      <div
        class="bg-blue-800 text-white rounded p-4 flex items-center justify-between"
      >
      <?php if(Session::has('user')) : ?>
        <div>
          <h2 class="text-xl font-semibold">Looking to hire?</h2>
          <p class="text-gray-200 text-lg mt-2">
            Post your job listing now and find the perfect candidate.
          </p>
        </div>
        <a
          href="/listings/create"
          class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"
        >
          <i class="fa fa-edit"></i> Post a Job
        </a>
      <?php else : ?>
        <div>
        <h2 class="text-xl font-semibold">Login or Register</h2>
          <p class="text-gray-200 text-lg mt-2">
            Create an account and find a perfect candidate for the job!
          </p>
          </div>
          <div class="space-x-4">
          <a href="/auth/login" class="text-white hover:underline">Login</a>
          <a href="/auth/register" class="text-white hover:underline">Register</a>
          </div>
        </div>
      <?php endif; ?>  
      </div>
    </section>
     
  </body>
</html>