const apiUrl = "/src/api/publishers.php";

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

// --- Publishers API ---
export async function fetchPublishers() {
  return request(apiUrl);
}

export async function addPublisher(name) {
  return request(apiUrl, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name }),
  });
}

export async function updatePublisher(id, name) {
  return request(`${apiUrl}?id=${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name }),
  });
}

export async function deletePublisher(id) {
  return request(`${apiUrl}?id=${id}`, { method: "DELETE" });
}
