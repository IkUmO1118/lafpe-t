import { ScoresState } from "../types/diagnosis";

export async function postDiagnosis(data: ScoresState) {
  try {
    console.log(data);
    const response = await fetch(
      `/api/diagnosis`,
      // `${import.meta.env.VITE_DEV_API_URL}/api/diagnosis`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
        cache: "no-cache",
        credentials: "include",
      },
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Failed to post diagnosis:", error);
    throw new Error(
      error instanceof Error ? error.message : "Failed to post diagnosis",
    );
  }
}

export async function updateDiganosis(data: ScoresState) {
  try {
    const response = await fetch(
      `/api/diagnosis`,
      // `${import.meta.env.VITE_DEV_API_URL}/api/diagnosis`,
      {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
        cache: "no-cache",
        credentials: "include",
      },
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Failed to update diagnosis:", error);
    throw new Error(
      error instanceof Error ? error.message : "Failed to update diagnosis",
    );
  }
}
