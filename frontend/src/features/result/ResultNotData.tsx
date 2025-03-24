import { useNavigate } from "react-router-dom";
import { Button } from "../../components/Button";
import { useMoveBack } from "../../hooks/useMoveBack";

function ResultNotData() {
  const moveBack = useMoveBack();
  const navigate = useNavigate();

  return (
    <section className="flex flex-col items-center justify-center px-4 py-12 text-center">
      <div className="mb-8 text-cyan-600">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          className="h-24 w-24"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth={2}
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 2a10 10 0 110 20 10 10 0 010-20z"
          />
        </svg>
      </div>
      <h1 className="mb-4 text-3xl font-bold text-neutral-900">
        診断結果がありません
      </h1>
      <p className="mb-8 max-w-md text-gray-600">
        診断が完了していないか、診断データが見つかりませんでした。
        診断を行うか、再度診断を完了させてからこのページにアクセスしてください。
      </p>

      <div className="flex flex-col gap-4 sm:flex-row">
        <Button
          variant="fillPrimary"
          size="base"
          onClick={() => navigate("/diagnosis")}
        >
          診断を開始する&nbsp;&nbsp;&rarr;
        </Button>
        <Button variant="outlinePrimary" size="base" onClick={moveBack}>
          前のページに戻る&nbsp;&nbsp;&larr;
        </Button>
      </div>
    </section>
  );
}

export default ResultNotData;
