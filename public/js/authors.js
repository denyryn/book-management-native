const apiUrl = "/src/api/authors.php";

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

export async function fetchAuthors() {
  return request(apiUrl);
}

export async function addAuthor(name) {
  return request(apiUrl, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name }),
  });
}

export async function updateAuthor(id, name) {
  return request(`${apiUrl}?id=${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name }),
  });
}

export async function deleteAuthor(id) {
  return request(`${apiUrl}?id=${id}`, { method: "DELETE" });
}
