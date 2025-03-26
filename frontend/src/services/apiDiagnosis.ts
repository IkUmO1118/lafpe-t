import { ScoresState } from "../types/diagnosis";

export async function postDiagnosis(data: ScoresState) {
  try {
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
      // レスポンスボディを取得
      const responseText = await response.text();
      console.log("Error response:", responseText); // デバッグ用

      // レスポンスが空でないか確認
      if (responseText && responseText.trim()) {
        try {
          // JSONとしてパース
          const errorData = JSON.parse(responseText);
          if (errorData && errorData.message) {
            // 直接メッセージを表示
            throw new Error(errorData.message);
          } else {
            throw new Error(`エラーが発生しました: ${response.status}`);
          }
        } catch (parseError) {
          console.error("Failed to parse error response:", parseError);

          // parseErrorのメッセージをそのまま使用
          if (parseError instanceof Error) {
            // テキスト内容も一緒に表示（デバッグに有用）
            throw new Error(parseError.message);
          } else {
            // テキストをそのまま表示
            throw new Error(
              responseText || `HTTP error! status: ${response.status}`,
            );
          }
        }
      } else {
        // レスポンスが空の場合
        throw new Error(`サーバーエラーが発生しました (${response.status})`);
      }
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Failed to post diagnosis:", error);
    throw error;
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
      // レスポンスボディを取得
      const responseText = await response.text();
      console.log("Error response:", responseText); // デバッグ用

      // レスポンスが空でないか確認
      if (responseText && responseText.trim()) {
        try {
          // JSONとしてパース
          const errorData = JSON.parse(responseText);
          if (errorData && errorData.message) {
            // 直接メッセージを表示
            throw new Error(errorData.message);
          } else {
            throw new Error(`エラーが発生しました: ${response.status}`);
          }
        } catch (parseError) {
          console.error("Failed to parse error response:", parseError);

          // parseErrorのメッセージをそのまま使用
          if (parseError instanceof Error) {
            // テキスト内容も一緒に表示（デバッグに有用）
            throw new Error(parseError.message);
          } else {
            // テキストをそのまま表示
            throw new Error(
              responseText || `HTTP error! status: ${response.status}`,
            );
          }
        }
      } else {
        // レスポンスが空の場合
        throw new Error(`サーバーエラーが発生しました (${response.status})`);
      }
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
