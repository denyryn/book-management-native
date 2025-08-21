const apiUrl = "/src/api/categories.php";

// --- Generic request helper ---
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

// --- Categories API ---
export async function fetchCategories() {
  return request(apiUrl);
}

export async function addCategory(name, slug = null) {
  const body = { name };
  if (slug) body.slug = slug;

  return request(apiUrl, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body),
  });
}

export async function updateCategory(id, name, slug = null) {
  const body = { name };
  if (slug) body.slug = slug;

  return request(`${apiUrl}?id=${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body),
  });
}

export async function deleteCategory(id) {
  return request(`${apiUrl}?id=${id}`, { method: "DELETE" });
}

export async function findCategory(id) {
  return request(`${apiUrl}?id=${id}`);
}

export async function findCategoryBySlug(slug) {
  return request(`${apiUrl}?slug=${encodeURIComponent(slug)}`);
}
