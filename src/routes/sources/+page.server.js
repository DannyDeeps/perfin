/** @type {import('./$types').PageServerLoad} */
export async function load({ fetch }) {
  const response = await fetch('/api/transactions/sources');
  const data = await response.json();
  return data;
}
