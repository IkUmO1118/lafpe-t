import CallToAction from "../features/home/CallToAction";
import PrincipleRadarChart from "../features/result/Charts";
import { useState } from "react";

interface DiagnosisResult {
  principle1: number;
  principle2: number;
  principle3: number;
  principle4: number;
  principle5: number;
  principleDP: number;
}

function Home() {
  const [message, setMessage] = useState("");
  const [data, setData] = useState<DiagnosisResult | null>(null);

  function handleClick() {
    const requestData = {
      Q1: [0],

      Q2: [0],

      Q3: {
        openRack: {
          isChecked: false,
        },
        IVCRack: {
          isChecked: true,
          per: 2,
          times: 3,
        },
        positiveRack: {
          isChecked: true,
          per: 0,
          times: 3,
        },
        negativeRack: {
          isChecked: true,
          per: 1,
          times: 3,
        },
        oneWayAirflowRack: {
          isChecked: false,
        },
        isolator: {
          isChecked: false,
        },
      },
      Q4: 2,

      Q5: 0,

      Q6: 2,

      Q7: [0],

      Q8: [0, 1, 2, 3],

      Q9: [0, 1, 2, 3],

      Q10: [0, 1, 2, 3],

      Q11: [0, 1, 2, 3],

      Q12: [4],

      Q13: [0],
    };
    fetch(import.meta.env.VITE_DEV_API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestData),
      cache: "no-cache",
      credentials: "include",
    })
      .then((response) => response.json())
      .then((data) => {
        setMessage(data.message);
        setData(data.diagnosis);
      })
      .catch((error) => console.error("Error fetching data:", error));
  }
  return (
    <div>
      <h1>Home</h1>
      <PrincipleRadarChart
        principle1={data?.principle1}
        principle2={data?.principle2}
        principle3={data?.principle3}
        principle4={data?.principle4}
        principle5={data?.principle5}
        dp={data?.principleDP}
      />
      <button
        onClick={handleClick}
        className="mb-4 rounded bg-blue-500 px-4 py-2 text-white"
      >
        診断開始
      </button>

      {data && (
        <div className="space-y-4">
          <p className="font-bold text-green-600">{message}</p>

          <div className="rounded border bg-gray-50 p-4">
            <h2 className="mb-2 font-bold">診断結果</h2>
            <div className="space-y-2">
              <p>原則1: {data.principle1.toFixed(2)}</p>
              <p>原則2: {data.principle2.toFixed(2)}</p>
              <p>原則3: {data.principle3.toFixed(2)}</p>
              <p>原則4: {data.principle4.toFixed(2)}</p>
              <p>原則5: {data.principle5.toFixed(2)}</p>
              <p className="font-bold">原則DP: {data.principleDP.toFixed(2)}</p>
            </div>
          </div>
        </div>
      )}
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <p>test</p>
      <CallToAction />
    </div>
  );
}

export default Home;
