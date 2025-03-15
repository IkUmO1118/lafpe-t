export async function postFeedback(message: string) {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_DEV_API_URL}/api/feedback`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ message }),
      },
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Failed to post feedback:", error);
    throw new Error(
      error instanceof Error ? error.message : "Failed to post feedback",
    );
  }
}
