import { ScoresState } from "../types/diagnosis";

export async function postDiagnosis(data: ScoresState) {
  try {
    const response = await fetch(`/api/diagnosis`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
      cache: "no-cache",
      credentials: "include",
    });

    const responseText = await response.text();

    if (!response.ok) {
      const errorData = JSON.parse(responseText);
      throw new Error(errorData.message);
    }

    const result = JSON.parse(responseText);
    return result;
  } catch (error) {
    console.error("Failed to post diagnosis:", error);
    throw error;
  }
}

export async function updateDiganosis(data: ScoresState) {
  try {
    const response = await fetch(`/api/diagnosis`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
      cache: "no-cache",
      credentials: "include",
    });

    const responseText = await response.text();

    if (!response.ok) {
      const errorData = JSON.parse(responseText);
      throw new Error(errorData.message);
    }

    const result = JSON.parse(responseText);
    return result;
  } catch (error) {
    console.error("Failed to update diagnosis:", error);
    throw new Error(
      error instanceof Error ? error.message : "Failed to update diagnosis",
    );
  }
}
