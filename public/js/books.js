const apiUrl = "/src/api/books.php";

async function request(url, options = {}) {
  try {
    const res = await fetch(url, options);
    const data = await res.json();
    if (!res.ok || data.success === false)
      throw new Error(data.error || "Unknown error");
    return data;
  } catch (err) {
    console.error("API request failed:", err);
    return { success: false, error: err.message };
  }
}

export async function fetchBooks() {
  return request(apiUrl);
}

export async function searchBooks(filters = {}) {
  const params = new URLSearchParams();

  if (filters.search) params.append("search", filters.search);
  if (filters.category) params.append("category", filters.category);
  if (filters.author) params.append("author", filters.author);
  if (filters.publisher) params.append("publisher", filters.publisher);
  if (filters.startDate) params.append("start_date", filters.startDate);
  if (filters.endDate) params.append("end_date", filters.endDate);

  const queryString = params.toString();
  const url = queryString ? `${apiUrl}?${queryString}` : apiUrl;

  return request(url);
}

export async function addBook(data) {
  return request(apiUrl, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
}

export async function updateBook(id, data) {
  return request(`${apiUrl}?id=${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
}

export async function deleteBook(id) {
  return request(`${apiUrl}?id=${id}`, { method: "DELETE" });
}
