import { Button } from "../components/Button";
import { useMoveBack } from "../hooks/useMoveBack";

function PageNotFound() {
  const moveBack = useMoveBack();
  return (
    <section className="flex min-h-[60vh] flex-col items-center justify-center px-4 py-8 text-center">
      <h1 className="text-8xl font-bold text-cyan-600">404</h1>
      <h2 className="mt-2 mb-4 text-2xl font-semibold">
        ページが見つかりません
      </h2>
      <p className="mb-8 max-w-md text-gray-600">
        お探しのページは移動されたか、削除された可能性があります。
        URLが正しいかご確認ください。
      </p>
      <Button variant="fillPrimary" size="base" onClick={moveBack}>
        戻る&nbsp;&nbsp;&rarr;
      </Button>
    </section>
  );
}

export default PageNotFound;
