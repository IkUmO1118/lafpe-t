import ResultContent from "../features/result/ResultContent";
import ResultHeader from "../features/result/ResultHeader";
import { useGetSession } from "../hooks/useSession";

function Result() {
  const kartesData = JSON.parse(useGetSession("karte"));
  const answersData = JSON.parse(useGetSession("answer"));

  if (kartesData === null || answersData === null) {
    return <div>データがありません</div>;
  }

  return (
    <section className="flex w-full flex-col">
      <ResultHeader answersData={answersData} kartesData={kartesData} />
      <ResultContent />
    </section>
  );
}

export default Result;
