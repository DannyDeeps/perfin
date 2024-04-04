<script>
  import '../app.scss';
  import SiteNav from '$lib/components/SiteNav.svelte';
  import { browser } from '$app/environment';

  if (browser) {
    window.bootstrap = import('bootstrap/dist/js/bootstrap.bundle.min.js');
  }
</script>

<SiteNav />

<slot />
